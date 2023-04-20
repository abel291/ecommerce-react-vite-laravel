<?php

namespace Database\Seeders;

use App\Models\CardProduct;
use App\Models\Product;
use App\Models\ShoppingCar;
use App\Models\User;
use Faker as Faker;
use Illuminate\Database\Seeder;

class ShoppingCartSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		ShoppingCar::truncate();


		foreach (User::get() as $user) {
			$shopping_cart = [];
			foreach (Product::get()->random(10) as $product) {
				$quantity = rand(1, $product->stock);
				$shopping_cart[$product->id] = [
					'quantity' => $quantity,
					'total_price_quantity' => $quantity * $product->price,
				];
			}
			$user->shopping_cart()->attach($shopping_cart);
		}
	}
}
