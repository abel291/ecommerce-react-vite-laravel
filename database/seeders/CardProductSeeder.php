<?php

namespace Database\Seeders;

use App\Models\CardProduct;
use App\Models\Product;
use App\Models\User;
use Faker as Faker;
use Illuminate\Database\Seeder;

class CardProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CardProduct::truncate();

        $faker = Faker\Factory::create();
        $products = Product::get();

        $data = [];
        foreach (User::get()->pluck('id')->toArray() as $user_id) {
            foreach ($products->random(20) as $product) {
                $quantity = rand(1, $product->availables);
                array_push($data, [
                    'user_id' => $user_id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'total_price_quantity' => round($quantity * $product->price, 2),
                ]);
            }
        }
        CardProduct::insert($data);
    }
}
