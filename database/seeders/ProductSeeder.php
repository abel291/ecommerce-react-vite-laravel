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
use App\Models\MetaTag;
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

        Image::where('model_type', 'App\Models\Product')->delete();

        $categories = Category::select('id', 'name')->pluck('id', 'name');
        $departments = Department::select('id', 'name')->pluck('id', 'name');

        $products = collect(Storage::json(DatabaseSeeder::getPathProductJson()));

        if (config('app.env') == 'testing') {
            $products = $products->take(20);
        }
        $colors = Color::pluck('id', 'name');

        $products_array = [];
        $products_variant_array = [];
        $images_array = [];
        $product_count = 1;
        $meta_array = [];
        foreach ($products as $product) {

            $this->command->info($product_count . ' - ' . $product['ref']);
            $product_base = [
                'name' => $product['name'],
                'slug' => Str::slug($product['name']) . "-" . $product['id'],
                'entry' => $product['entry'],
                'description' => fake()->text(800),
                'max_quantity' => rand(1, 100),
                'featured' => boolval(rand(0, 1000)),
                'department_id' => $departments[$product['department']],
                'category_id' => $categories[$product['category']],
                'created_at' => now(),
                'updated_at' => now(),
            ];
            array_push($products_array, [
                'id' => $product['id'],
                ...$product_base
            ]);

            foreach ($product['variants'] as $variant) {

                $color_id = $colors[$variant['color']['name']];

                $time_fake = fake()->dateTime()->format('hi');
                $ref = str_pad($product['id'], 4, "0", STR_PAD_LEFT) . '-' . str_pad($time_fake, 3, "0", STR_PAD_LEFT);

                if (rand(0, 10)) {
                    $old_price = $product['price'];
                    $offer = fake()->randomElement([10, 20, 30, 40, 50]);
                    $price = $old_price - ($old_price * ($offer / 100));
                } else {
                    $offer = null;
                    $old_price = null;
                    $price = $product['price'];
                }
                array_push($products_variant_array, [
                    ...$product_base,
                    'id' => $variant['id'],
                    'ref' => $ref,
                    'old_price' => $old_price,
                    'offer' => $offer,
                    'price' => $price,
                    'img' => $variant['img'],
                    'thumb' => $variant['thumb'],
                    'color_id' => $color_id,
                    'parent_id' => $product['id'],
                    'created_at' => fake()->dateTimeBetween('-2 days', 'now'),
                    'updated_at' => fake()->dateTimeBetween('-2 days', 'now'),

                ]);
                $product_count++;
                foreach ($variant['images'] as $key => $image) {
                    array_push($images_array, [
                        'img' => $image,
                        'title' => $product['name'],
                        'alt' => $product['name'],
                        'sort' => $key + 1,
                        'model_type' => 'App\Models\Product',
                        'model_id' => $variant['id'],
                    ]);
                }
                array_push($meta_array, [
                    'meta_title' => $product['name'],
                    'meta_description' => fake()->sentence(),
                    'model_type' => 'App\Models\Product',
                    'model_id' => $variant['id'],
                ]);
            }

            if (count($products_variant_array) > 50) {
                Product::insert($products_array);
                Product::insert($products_variant_array);
                Image::insert($images_array);
                MetaTag::insert($meta_array);
                $products_array = [];
                $products_variant_array = [];
                $images_array = [];
                $meta_array = [];
            }
        }

        Product::insert($products_array);
        Product::insert($products_variant_array);
        Image::insert($images_array);
        MetaTag::insert($meta_array);
    }
}
