<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatusEnum;
use App\Enums\SaleStatuEnum;
use App\Models\Order;
use App\Models\Product;
use App\Models\Sale;
use Dashboard;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;

class SalesChart extends ChartWidget
{
    use InteractsWithPageFilters;
    protected static ?int $sort = 2;
    protected static ?string $heading = 'Ventas por mes';
    protected static bool $isLazy = false;
    protected function getData(): array
    {
        $filterMonth = Dashboard::filterDateSelected($this->filters['select_month']);


        $sales = Order::select('id', 'created_at', 'status')
            ->where('status', OrderStatusEnum::SUCCESSFUL)
            ->when($filterMonth, fn(Builder $query) => $query->whereDate('created_at', '>=', $filterMonth))
            ->orderBy('created_at')
            ->get();

        $salesPerMonth = $sales->groupBy(function ($sale) {
            return ucfirst($sale->created_at->isoFormat('MMMM YYYY'));
        })->map(function ($item) {
            return $item->count();
        });

        return [
            'datasets' => [
                [
                    'label' => 'Ventas',
                    'data' => $salesPerMonth->values()->toArray(),
                    'animations' => [
                        'tension' => [
                            'duration' => 1000,
                            'easing' => 'linear',
                            'from' => 1,
                            'to' => 0,
                            'loop' => true
                        ]
                    ],
                    'scales' => [
                        ' y' => [
                            'beginAtZero' => true
                        ]
                    ]
                ],
            ],
            'labels' => $salesPerMonth->keys()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
