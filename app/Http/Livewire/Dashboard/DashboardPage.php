<?php

namespace App\Http\Livewire\Dashboard;

use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use Livewire\Component;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class DashboardPage extends Component
{
	public function render()
	{

		$users_register = User::whereMonth('created_at', now()->month)->get();

		$orders_completed = Order::with('order_products.product.category')->whereMonth('created_at', now()->month)->whereRelation(
			'payment',
			'status',
			PaymentStatus::SUCCESSFUL
		)->get();

		$products_quantity = $orders_completed->sum('quantity');

		$order_products = $orders_completed->pluck('order_products')->collapse();
		$product_category = $order_products->groupBy('product.category.name')->map(function ($item) {
			return $item->count();
		});

		$popular_product = $order_products->groupBy('product_id')->sortByDesc(function ($item) {
			return $item->count();
		})->first()->first()->product;

		$revenues = $orders_completed->sum('total');

		return view('livewire.dashboard.dashboard-page', [
			'users_register' => $users_register,
			'orders_completed' => $orders_completed,
			'products_quantity' => $products_quantity,
			'revenues' => $revenues,
			'product_category' => $product_category,
			'popular_product' => $popular_product,

		]);
	}
}
