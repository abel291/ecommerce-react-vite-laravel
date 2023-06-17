<?php

namespace Database\Seeders;

use App\Enums\CartEnum;
use App\Enums\PaymentStatus;

use App\Models\CodeDiscount;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use App\Services\CartService;
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
		Payment::truncate();
		DiscountCode::truncate();
		OrderProduct::whereNotNull('order_id')->delete();
		$users = User::get();
		$discount_codes = DiscountCode::factory()->count(30)->create();

		foreach ($users as $user) {
			for ($i = 0; $i < rand(5, 10); $i++) {


				$discount_code = $discount_codes->random();

				$max_quantity_selected = rand(1, 30);

				$products = Product::select('id', 'name', 'price_offer', 'max_quantity')->where('active', 1)->whereRelation(
					'stock',
					'remaining',
					'>=',
					$max_quantity_selected
				)
					->inRandomOrder()
					->limit(rand(1, 9))->get();

				$cart_products = $products->map(function ($product) use ($max_quantity_selected) {
					$quantity_selected = rand(1, $max_quantity_selected);
					return CartService::generateCartProduct($product, $quantity_selected);
				});

				$order = OrderService::calculateTotals($cart_products, $discount_code);

				$order->code =  OrderService::generateCode($user->id);
				$order->user_id =  $user->id;
				$order->user_data = $user->only(['name', 'email', 'phone', 'address', 'city']);
				$order->save();

				$order_products = $cart_products->map(function ($item) {
					$item->type = CartEnum::ORDER;
					return  $item;
				});

				$order->order_products()->saveMany($order_products);

				$payment = Payment::factory()->make();

				$order->payment()->save($payment);
			}
		}
	}
}
