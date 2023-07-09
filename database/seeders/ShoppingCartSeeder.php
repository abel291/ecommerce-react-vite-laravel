<?php

namespace Database\Seeders;

use App\Enums\CartEnum;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Database\Seeder;

class ShoppingCartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(CartService $card_service)
    {
        OrderProduct::where('type', CartEnum::SHOPPIN_CART)->delete();
        $products = Product::get();
        foreach (User::get() as $user) {
            foreach ($products->random(6) as $product) {
                $quantity_selected = rand(3, 6);
                $card_service->addProduct($user, $product, $quantity_selected);
            }
        }
    }
}
