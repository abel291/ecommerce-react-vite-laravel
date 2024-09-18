<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Enums\OrderStatusEnum;
use App\Enums\SaleStatuEnum;
use App\Models\Order;
use App\Models\Sale;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class OrderStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $orders = Order::where("status", OrderStatusEnum::SUCCESSFUL)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)->get();

        $chartSalesMonth = $orders->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        })->map(function ($item) {
            return $item->count();
        })->values()->toArray();

        return [
            Stat::make('Ventas de ' . now()->translatedFormat('F'), $orders->count())
                ->chart($chartSalesMonth),
            Stat::make('Total ingresos', Number::currency($orders->sum('total') ?: 0)),
            Stat::make('Venta promedio', Number::currency($orders->average('total') ?: 0)),
        ];
    }
}
