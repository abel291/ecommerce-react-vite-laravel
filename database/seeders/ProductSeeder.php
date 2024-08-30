<?php

namespace Database\Seeders;

use App\Helpers\Helpers;
use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\AttributeProduct;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Department;
use App\Models\Image;
use App\Models\Presentation;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\Sku;
use App\Models\Specification;
use App\Models\SpecificationValue;
use App\Models\Stock;
use Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Product::truncate();
        Specification::truncate();
        SpecificationValue::truncate();

        // Image::where('model_type', 'App\Models\Product')->delete();

        $categories = Category::select('id', 'name')->get()->pluck('id', 'name');
        $departments = Department::select('id', 'name')->get()->pluck('id', 'name');
        $brands = Brand::select('id', 'name')->get()->pluck('id', 'name');

        $products = collect(Storage::json(DatabaseSeeder::getPathProductJson()))->shuffle();

        if (config('app.env') == 'testing') {
            $products = $products->take(20);
        }

        // $images_array = [];
        $products_array = [];
        foreach ($products as $product_key => $product) {

            if (rand(0, 5)) {
                $old_price = $product['price'];
                $offer = fake()->randomElement([10, 20, 30, 40, 50]);
                $price = $old_price - ($old_price * ($offer / 100));
            } else {
                $offer = null;
                $old_price = null;
                $price = $product['price'];
            }

            $this->command->info($product_key . ' - ' . $product['name']);

            array_push($products_array, [
                'id' => $product['id'],
                'name' => $product['name'],
                'slug' => Str::slug($product['name']) . "-" . $product['id'],
                // 'img' => $product['img'],
                // 'thumb' => $product['thumb'],
                'old_price' => $old_price,
                'entry' => $product['entry'],
                'description' => fake()->text(800),
                'offer' => $offer,
                'price' => $price,
                'max_quantity' => rand(6, 12),
                'department_id' => $departments[$product['department']],
                'category_id' => $categories[$product['category']],
                // 'brand_id' => $brands[$product['brand']],
                'created_at' => now(),
                'updated_at' => now(),
            ]);



            if (count($products_array) > 1000) {
                // Image::insert($images_array);
                Product::insert($products_array);
                // $images_array = [];
                $products_array = [];
            }
        }
        // Image::insert($images_array);
        Product::insert($products_array);
    }
}
