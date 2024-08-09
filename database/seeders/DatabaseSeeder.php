<?php

namespace Database\Seeders;

use App\Helpers\Helpers;
use App\Models\Category;
use App\Models\Department;
use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $products = collect(Storage::json('/products/products-clothes-old.json'))->map(function ($item, $key) {
        //     $item['id'] = $key + 1;
        //     return $item;
        // })->toArray();

        // Storage::put("/products/products-clothes.json", json_encode($products, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        // $products = collect(Storage::json('/products/products-pc-old.json'))->map(function ($item, $key) {
        //     $item['id'] = $key + 1;
        //     return $item;
        // })->toArray();

        // Storage::put("/products/products-pc.json", json_encode($products, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));


        Cache::flush();
        Schema::disableForeignKeyConstraints();

        $this->call([
            // JsonDataSeeder::class,
            UserSeeder::class,
            PageSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            BlogSeeder::class,
            // AttributeSeeder::class,
            ProductSeeder::class,
            PresentationSeeder::class,
            // OrderSeeder::class,

        ]);
        Schema::enableForeignKeyConstraints();
    }
}
