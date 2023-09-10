<?php

namespace Database\Seeders;

use App\Helpers\Helpers;
use App\Models\Attribute;
use App\Models\AttributeProduct;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Department;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\Specification;

use App\Models\Stock;
use Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        Stock::truncate();
        Specification::truncate();
        Attribute::truncate();
        AttributeValue::truncate();
        //$brands = Brand::get();

        $categories = Category::select('id', 'name')->get()->pluck('id', 'name');

        $departments = Department::select('id', 'name')->get()->pluck('id', 'name');

        $brands = Brand::select('id', 'name', 'slug')->get()->pluck('id', 'slug');

        $products = Helpers::getAllProducts();

        if (config('app.env') == 'testing') {
            $products = $products->random(20);
        }

        $faker = Faker\Factory::create();

        foreach ($products as $key => $product) {

            $price = $product['price'] / 4500;

            $offer = rand(0, 1) ? $faker->randomElement([10, 20, 30, 40, 50]) : 0;

            $price_offer = $price - ($price * ($offer / 100));

            $cost = round($price * 0.80);

            echo ($key + 1) . ' - ' . $product['name'] . " \n";

            $product_model = Product::factory()
                ->has(Stock::factory()->count(1))
                ->create([
                    'name' => $product['name'],
                    'slug' => Str::slug($product['name'], '-') . rand(0, 999),
                    'img' => $product['img'],
                    'thumb' => $product['thumb'],
                    //'description_min' => $product['entry'],
                    'description_max' => $product['desc'],
                    'price' => $price,
                    'offer' => $offer,
                    'price_offer' => $price_offer,
                    'cost' => $cost,
                    'department_id' => $departments[$product['department']],
                    'category_id' => $categories[$product['category']],
                    'sub_category_id' => null,
                    'brand_id' => $brands[$product['brand']],
                ]);

            $product_model->images()->createMany($product['images']);
            $specifications = [];
            foreach ($product['specifications'] as $key => $item) {
                foreach ($item['table'] as $key => $table) {
                    array_push($specifications, [
                        'type' => $item['title'],
                        'name' => $table['name'],
                        'slug' => Str::slug($table['name']),
                        'value' => $table['value'],
                        'active' => 1,
                    ]);
                }
            }
            $product_model->specifications()->createMany($specifications);

            foreach ($product['attributes'] as  $item) {

                $product_attribute = Attribute::create([
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name']),
                    'product_id' => $product_model->id,
                ]);

                $attribute_values = [];
                foreach ($item['value'] as $key => $value) {
                    $attribute_values[] = [
                        'name' => $value,
                        'slug' => Str::slug($value),
                        'default' => $key == 0,
                        'in_stock' => $key == 0 ? 1 : rand(0, 1),
                        'product_id' => $product_model->id,
                    ];
                }
                $product_attribute->attribute_values()->createMany($attribute_values);
            }
        }
    }
    public static function addAttribute($product, $attributes_array)
    {
    }
}
