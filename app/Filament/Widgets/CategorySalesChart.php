<?php

namespace App\Filament\Widgets;

use App\Enums\OrderStatusEnum;
use App\Enums\SaleStatuEnum;
use App\Models\Category;
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

        $categories = Category::withWhereHas(
            'products',
            function ($query) use ($filterMonth) {
                $query
                    ->select('id', 'orders_count')
                    ->withCount([
                        'orders' => function (Builder $query2) use ($filterMonth) {
                            $query2->where('orders.status', OrderStatusEnum::SUCCESSFUL)
                                ->when($filterMonth, fn(Builder $query) => $query->whereDate('orders.created_at', '>=', $filterMonth));
                        }
                    ]);
            }
        )->where('type', 'product')->get()->mapWithKeys(function ($category, int $key) {
            return [$category->name => $category->products->sum('orders_count')];
        })->sortDesc()->take(10);

        // $sales = Sale::with('products.category')
        //     ->where('status', SaleStatuEnum::ACCEPTED)
        //     ->whereDate('sales.created_at', '>=', $filterMonth)->get();
        // dd($sales->pluck('products')->collapse()->groupBy('category.name'));

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
