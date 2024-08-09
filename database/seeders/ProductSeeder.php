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
        Attribute::truncate();
        AttributeValue::truncate();
        Image::where('model_type', 'App\Models\Product')->delete();

        $categories = Category::select('id', 'name')->get()->pluck('id', 'name');
        $departments = Department::select('id', 'name')->get()->pluck('id', 'name');
        $brands = Brand::select('id', 'name')->get()->pluck('id', 'name');

        $products = collect(Storage::json(env('DB_FAKE_PRODUCTS')))->shuffle();

        if (config('app.env') == 'testing') {
            $products = collect($products)->random(20);
        }

        $images_array = [];
        foreach ($products as $key => $product) {

            $price = $product['price'];

            $offer = rand(0, 1) ? fake()->randomElement([10, 20, 30, 40, 50]) : 0;

            $price_offer = $price - ($price * ($offer / 100));

            $this->command->info(($key + 1) . ' - ' . $product['name']);

            Product::create([
                'id' => $product['id'],
                'name' => $product['name'],
                'slug' => Str::slug($product['name'], '-') . fake()->bothify('####'),
                'img' => $product['img'],
                'thumb' => $product['thumb'],
                'price' => $price,
                'offer' => $offer,
                'price_offer' => $price_offer,
                'max_quantity' => rand(12, 24),
                'department_id' => $departments[$product['department']],
                'category_id' => $categories[$product['category']],
                'brand_id' => $brands[$product['brand']],
            ]);

            // --images
            $images_array = [];
            foreach ($product['images'] as  $images) {
                array_push($images_array, [
                    ...$images,
                    'model_type' => 'App\Models\Product',
                    'model_id' => $product['id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            Image::insert($images_array);

            // --specifications
            foreach ($product['specifications'] as  $specification) {

                $specification_model = Specification::create([
                    'name' => $specification['title'],
                    'product_id' => $product['id'],
                ]);

                $specification_values = [];
                foreach ($specification['table'] as $specification_value) {
                    array_push($specification_values, [
                        ...$specification_value,
                        'specification_id' => $specification_model->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                SpecificationValue::insert($specification_values);
            }

            // --attributes
            foreach ($product['attributes'] as  $attribute) {

                $attribute_model = Attribute::create([
                    'name' => $attribute['name'],
                    'product_id' => $product['id'],
                ]);

                $attribute_values = [];
                foreach ($attribute['value'] as $value) {
                    array_push($attribute_values, [
                        'value' => $value,
                        'attribute_id' => $attribute_model->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                AttributeValue::insert($attribute_values);
            }
        }
    }
}
