<?php

namespace Database\Seeders;

use App\Enums\CartEnum;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Payment;
use App\Models\Product;
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
		OrderProduct::truncate();
		Payment::truncate();
		DiscountCode::truncate();
		OrderProduct::whereNotNull('order_id')->delete();
		$users = User::get();
		$discount_codes = DiscountCode::factory()->count(30)->create();

		foreach ($users as $user) {
			for ($i = 0; $i < rand(5, 10); $i++) {

				if (rand(0, 2) == 0) {
					$discount_code = $discount_codes->random();
				} else {
					$discount_code = null;
				}

				$max_quantity_selected = rand(1, 10);

				$orderProducts = Product::select('id', 'slug', 'img', 'name', 'price_offer', 'max_quantity')
					->where('active', 1)
					->with('attributes.attribute_values')
					->whereRelation(
						'stock',
						'remaining',
						'>=',
						$max_quantity_selected
					)
					->inRandomOrder()
					->limit(rand(1, 9))
					->get()
					->map(function ($product) use ($max_quantity_selected, $user) {

						$attributes = $product->attributes->map(function ($attribute) {
							return [
								'name' => $attribute->name,
								'value' => $attribute->attribute_values->where('in_stock', 1)->random()->name
							];
						});

						$quantity = rand(1, $max_quantity_selected);
						return [
							'price' => $product->price_offer,
							'quantity' => $quantity,
							'total' => $product->price_offer * $quantity,
							'data' => $product->only('id', 'name', 'slug', 'img', 'price', 'offer', 'price_offer'),
							'attributes' => $attributes,
							'user_id' => $user->id,
							'product_id' => $product->id,
						];
					});

				$total = OrderService::calculateTotal($orderProducts->sum('total'), $discount_code);
				$order = OrderService::createOrderWithTotalCalculation($total);
				$order->quantity = $orderProducts->sum('quantity');
				$order->code = OrderService::generateCode($user->id);
				$order->data = [
					'user' => $user->only('name', 'address', 'phone', 'email', 'city'),
				];
				$order->user_id = $user->id;
				$order->save();
				$order->order_products()->createMany($orderProducts);
				$payment = Payment::factory()->make();
				$order->payment()->save($payment);

				echo "Orden $order->id : $order->code \n";
			}
		}
	}
}
