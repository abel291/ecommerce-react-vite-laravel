<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Order::truncate();
		OrderProduct::truncate();
		$users = User::get();
		//$products = Product::with('stock')->get();
		//$stock = Stock::with('product')->get();

		for ($i = 0; $i < 200; $i++) {
			$user = $users->random();
			$quantity_selected = rand(1, 10);
			$products_selected_order = Product::whereRelation(
				'stock',
				'remaining',
				'>=',
				$quantity_selected
			)
				->inRandomOrder()
				->limit(5)->get();

			$products_selected_order->transform(function ($item) use ($quantity_selected) {
				$item->quantity_selected = $quantity_selected;
				$item->price_quantity = $item->price * $item->quantity_selected;
				return $item;
			});

			$amount = $products_selected_order->sum('price_quantity');

			$charges = OrderService::calculate_total_price($amount);
			$status = ['success', 'refunded', 'canceled'];
			//dd($charges['sub_total']);
			$order = Order::create([
				'code' => OrderService::generate_code($user->id),
				'quantity' => $products_selected_order->sum('quantity_selected'),
				'shipping' => $charges['shipping'],
				'tax_amount' => $charges['tax_amount'],
				'tax_percent' => $charges['tax_percent'],
				'sub_total' => $charges['sub_total'],
				'total' => $charges['total'],
				'user_id' => $user->id,
				'user_json' => $user->only(['name', 'email', 'phone']),
				'status' => $status[rand(0, 2)],
			]);

			$order_products = $products_selected_order->map(function ($item) {
				return [
					'name' => $item->name,
					'price' => $item->price,
					'quantity' => $item->quantity_selected,
					'price_quantity' => $item->price_quantity,
					'product_id' => $item->id,
				];
			});
			$order_products->toArray();

			$order->order_products()->createMany($order_products);
		}
	}
}
