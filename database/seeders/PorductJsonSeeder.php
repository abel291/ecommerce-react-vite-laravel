<?php

namespace Database\Seeders;

use App\Helpers\Helpers;
use App\Models\Brand;
use Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PorductJsonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Storage::put("/products/products-clothes.json", json_encode($products, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        $products = collect(Storage::json(DatabaseSeeder::getPathProductJson()))->map(function ($product) {
            $productwithColor = $product->colors->map(function ($color) {

            });
        });

        Storage::put('productsNoGroupBy.json', json_encode($products, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

    }
}
