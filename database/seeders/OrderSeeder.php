<?php

namespace Database\Seeders;

use App\Enums\PaymentStatus;

use App\Models\CodeDiscount;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Payment;
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
		Payment::truncate();
		DiscountCode::truncate();

		$users = User::get();
		$discount_codes = DiscountCode::factory()->count(30)->create();

		for ($i = 0; $i < 200; $i++) {

			$user = $users->random();
			$discount_code = $discount_codes->random();

			$quantity_selected = rand(1, 10);
			$products_selected_order = Product::whereRelation(
				'stock',
				'remaining',
				'>=',
				$quantity_selected
			)
				->inRandomOrder()
				->limit(rand(1, 9))->get();

			$products_selected_order->transform(function ($item) use ($quantity_selected) {
				$item->quantity_selected = rand(1, $quantity_selected);
				$item->price_quantity = $item->price * $item->quantity_selected;
				return $item;
			});

			$charges = OrderService::calculate_total_price($products_selected_order, $discount_code);

			$order = Order::create([
				'code' => OrderService::generate_code($user->id),
				'quantity' => $products_selected_order->sum('quantity_selected'),
				'shipping' => $charges['shipping'],
				'tax_amount' => $charges['tax_amount'],
				'tax_percent' => $charges['tax_percent'],
				'sub_total' => $charges['sub_total'],
				'total' => $charges['total'],
				'discount' => $charges['discount'],
				'user_data' => $user->only(['name', 'email', 'phone', 'address', 'country', 'city']),
				'user_id' => $user->id,
				'discount_code_id' => $discount_code->id,

			]);

			$payment = Payment::factory()->make();

			$order->payment()->save($payment);

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
