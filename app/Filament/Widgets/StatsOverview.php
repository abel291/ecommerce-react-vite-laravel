<?php

namespace App\Filament\Widgets;

use App\Enums\ContactTypesEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\SaleStatuEnum;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Payroll;
use App\Models\Product;
use App\Models\Sale;
use Dashboard;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Number;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static bool $isLazy = false;
    protected static ?int $sort = 0;
    protected function getStats(): array
    {

        $filterMonth = Dashboard::filterDateSelected($this->filters['select_month']);


        $orders = Order::select('id', 'status', 'created_at', 'total')
            ->where('status', OrderStatusEnum::SUCCESSFUL)
            ->when($filterMonth, fn(Builder $query) => $query->whereDate('created_at', '>=', $filterMonth))
            ->orderBy('created_at', 'desc')->get();

        $ordersPerDays = $orders->groupBy(function ($sale) {
            return (int) $sale->created_at->format('d');
        })->map(function ($item) {
            return $item->count();
        });

        // $payrolls = Payroll::select('id', 'amount', 'created_at')
        //     ->when($filterMonth, fn(Builder $query) => $query->whereDate('created_at', '>=', $filterMonth))
        //     ->orderBy('created_at', 'desc')->get();

        // $payrollsPerDays = $payrolls->groupBy(function ($payroll) {
        //     return (int) $payroll->created_at->format('d');
        // })->map(function ($item) {
        //     return $item->count();
        // });

        $productBestSeller = Product::select('id', 'name', 'price')->variant()
            ->whereHas('orders', function (Builder $query) use ($filterMonth) {
                $query->select('orders.id', 'status', 'orders.created_at')->where('status', OrderStatusEnum::SUCCESSFUL)
                    ->when($filterMonth, fn(Builder $query) => $query->whereDate('orders.created_at', '>=', $filterMonth));
            })->bestSeller()->first();




        return [
            Stat::make('Ventas', $orders->count() . ' ventas')
                ->description(Number::currency($orders->sum('total')))
                ->chart($ordersPerDays->toArray())->color('success'),

            // Stat::make('Pago de Nominas', $payrolls->count() . ' pagos')
            //     ->color('danger')
            //     ->description(Number::currency($payrolls->sum('amount')))
            //     ->chart($payrollsPerDays->toArray()),

            Stat::make('Producto mas vendido', $productBestSeller->orders_count . ' ventas')
                ->description($productBestSeller->name . ' ' . Number::currency($productBestSeller->price)),

            Stat::make('Precio medio de ventas', Number::currency($orders->avg('total'), 'COP', locale: 'es')),

        ];
    }
}
