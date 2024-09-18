<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatusEnum;
use App\Enums\SaleStatuEnum;
use App\Models\Category;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Sale;
use Dashboard;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Number;

class CategorySalesChart extends ChartWidget
{
    use InteractsWithPageFilters;
    protected static ?int $sort = 2;
    protected static ?string $heading = 'Top 10 categorias con mas ventas';
    protected static bool $isLazy = false;
    protected function getData(): array
    {

        $filterMonth = Dashboard::filterDateSelected($this->filters['select_month']);

        $categories = Category::select('id', 'name')->withCount(['order_products' => function (Builder $query2) use ($filterMonth) {
            $query2->whereRelation('order', 'status', '=', OrderStatusEnum::SUCCESSFUL->value)
                ->when($filterMonth, fn(Builder $query) => $query->whereDate('created_at', '>=', $filterMonth));
        }])->orderBy('order_products_count', 'desc')->limit(10)->pluck('order_products_count', 'name');

        self::$heading = self::$heading . " (" . Number::format($categories->sum()) . " productos vendidos)";
        return [
            'datasets' => [
                [
                    'label' => 'Ventas',
                    'data' => $categories->values()->toArray(),

                ],
            ],
            'labels' => $categories->keys()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
