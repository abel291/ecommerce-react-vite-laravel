<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Contracts\Database\Query\Builder;
// use Illuminate\Database\Query\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class DashboardProductOutStock extends Component
{
    use WithPagination;

    public function render()
    {
        $products_out_stock = Product::active()->with('stock')->whereHas('stock', function (Builder $query) {
            $query->whereRaw('remaining <= quantity*?', [0.2]);
        })->orderBy(Stock::select('remaining')->whereColumn('stock.product_id', 'products.id'), 'asc')
            ->paginate(8);

        return view('livewire.dashboard.dashboard-product-out-stock', [

            'products_out_stock' => $products_out_stock,

        ]);
    }
}
