<?php

namespace Database\Seeders;

use App\Models\CardProduct;
use App\Models\Product;

use App\Models\ShoppingCart;
use App\Models\User;
use App\Services\OrderService;
use App\Services\ShoppingCartService;
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
		ShoppingCart::truncate();
		foreach (User::get() as $user) {
			foreach (Product::get()->random(4) as $product) {
				$quantity = rand(1, 5);
				ShoppingCartService::addProduct($user, $product, $quantity);
			}
		}
	}
}
