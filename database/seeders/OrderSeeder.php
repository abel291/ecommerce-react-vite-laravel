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


		foreach ($users as $user) {

			$discount_code = $discount_codes->random();

			$max_quantity_selected = rand(1, 10);
			$quantities_selected = [];
			$products = Product::select('id', 'name', 'price_offer', 'max_quantity')->where('active', 1)->whereRelation(
				'stock',
				'remaining',
				'>=',
				$max_quantity_selected
			)
				->inRandomOrder()
				->limit(rand(1, 9))->get();

			foreach ($products as $item) {
				$quantities_selected[$item->id] = rand(1, $max_quantity_selected);
			}

			$productsPricesQuantity = OrderService::priceQuantity($products, $quantities_selected);

			$charges = OrderService::calculateTotalPrice($productsPricesQuantity, $discount_code);

			$order = Order::create([
				'code' => OrderService::generate_code($user->id),
				'quantity' => $charges['quantity'],
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

			$order_products = $productsPricesQuantity->map(function ($item) {
				return [
					'name' => $item->name,
					'price' => $item->price_offer,
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
