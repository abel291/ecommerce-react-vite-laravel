<?php

namespace App\Filament\Widgets;

use App\Enums\ContactTypesEnum;
use App\Enums\OrderStatusEnum;
use App\Enums\SaleStatuEnum;
use App\Models\Contact;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Payroll;
use App\Models\Product;
use App\Models\Sale;
use Dashboard;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
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

        $ordersPerDays = $orders->groupBy(function ($order) {
            return (int) $order->created_at->format('d');
        })->map(function ($item) {
            return $item->count();
        });

        $productBestSeller = OrderProduct::select('id', 'name', 'price', 'product_id', 'order_id', DB::raw('count(*) as products_count'))
            ->groupBy('product_id')
            // ->having('product_id')
            ->orderBy('products_count', 'desc')
            ->when($filterMonth, fn(Builder $query) => $query->whereDate('created_at', '>=', $filterMonth))
            // ->whereRelation('order', 'status', '=', OrderStatusEnum::SUCCESSFUL->value)
            ->first();


        // dd($productBestSeller);
        // $productBestSeller = Product::select('id', 'name', 'price')->variant()
        //     // ->whereHas('orders', function (Builder $query) use ($filterMonth) {
        //     //     $query->select('orders.id', 'status', 'orders.created_at')
        //     //         // ->where('status', OrderStatusEnum::SUCCESSFUL)
        //     //         ->when($filterMonth, fn(Builder $query) => $query->whereDate('orders.created_at', '>=', $filterMonth));
        //     // })
        //     ->bestSeller()->first();

        if ($productBestSeller) {
            $statProductBestSeller = Stat::make('Producto mas vendido', $productBestSeller->products_count . ' ventas')
                ->description($productBestSeller->name . ' ' . Number::currency($productBestSeller->price));
        } else {
            $statProductBestSeller = Stat::make('Producto mas vendido', '0 ventas')
                ->description('No hay suficientes datos');
        }

        return [
            Stat::make('Ventas', $orders->count() . ' ventas')
                ->description(Number::currency($orders->sum('total')))
                ->chart($ordersPerDays->toArray())->color('success'),

            $statProductBestSeller,


            Stat::make('Precio medio de ventas', Number::currency($orders->avg('total') ?: 0, 'COP', locale: 'es'))
        ];
    }
}
