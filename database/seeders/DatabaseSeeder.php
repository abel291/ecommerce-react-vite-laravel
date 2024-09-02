<?php

namespace Database\Seeders;

use App\Helpers\Helpers;
use App\Models\Attribute\ColorAttribute;
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

        // $products = collect(Storage::json(DatabaseSeeder::getPathProductJson()))->toArray();

        // $variants_id = count($products) + 1;
        // foreach ($products as $product_key => $product) {
        //     foreach ($product['variants'] as $variantKey => $variant) {
        //         $products[$product_key]['variants'][$variantKey]['id'] = $variants_id;
        //         $variants_id++;
        //     }
        // }

        // Storage::put('/products/productWithImages2.json', json_encode($products, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));



        Cache::flush();
        Schema::disableForeignKeyConstraints();
        ini_set('memory_limit', '500M');
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            BlogSeeder::class,
            ColorSizeSeeder::class,
            ProductSeeder::class,
            VariantSeeder::class,
            SkuSeeder::class,
            AttributeSeeder::class,
            PageSeeder::class,
            SpecificationSeeder::class,
            DiscountCodeSeeder::class
            // OrderSeeder::class,

        ]);
        Schema::enableForeignKeyConstraints();
    }

    public static function getPathProductJson()
    {
        return '/products/productWithImages2.json';
    }
}
