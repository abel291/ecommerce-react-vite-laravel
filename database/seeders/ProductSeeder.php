<?php

namespace Database\Seeders;

use App\Helpers\Helpers;
use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\AttributeProduct;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
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
        Product::where('type', 'product')->delete();
        Specification::truncate();
        SpecificationValue::truncate();

        // Image::where('model_type', 'App\Models\Product')->delete();

        $categories = Category::select('id', 'name')->pluck('id', 'name');
        $departments = Department::select('id', 'name')->pluck('id', 'name');

        $products = collect(Storage::json(DatabaseSeeder::getPathProductJson()));

        if (config('app.env') == 'testing') {
            $products = $products->take(20);
        }

        $products_array = [];
        foreach ($products as $product) {

            $this->command->info($product['id'] . ' - ' . $product['name']);

            array_push($products_array, [
                'id' => $product['id'],
                'name' => $product['name'],
                'slug' => Str::slug($product['name']) . "-" . $product['id'],
                'entry' => $product['entry'],
                'description' => fake()->text(800),
                'department_id' => $departments[$product['department']],
                'category_id' => $categories[$product['category']],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (count($products_array) > 100) {
                Product::insert($products_array);
                $products_array = [];
            }
        }

        Product::insert($products_array);
    }
}
