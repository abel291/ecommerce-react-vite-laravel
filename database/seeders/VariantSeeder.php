<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Attribute\ColorAttribute;
use App\Models\Attribute\SizeAttribute;
use App\Models\AttributeOption;
use App\Models\AttributeValue;
use App\Models\Color;
use App\Models\Image;
use App\Models\Product;
use App\Models\Size;
use App\Models\Sku;
use App\Models\Variant;
use Illuminate\Support\Str;

use Illuminate\Database\Seeder;
use Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Sku::truncate();
        Variant::where('type')->delete();
        Image::where('model_type', 'App\Models\Variant')->delete();

        $products = collect(Storage::json(DatabaseSeeder::getPathProductJson()));
        $colors = Color::pluck('id', 'name');
        $product_variant_array = [];
        $images_array = [];

        foreach ($products as $key => $product) {
            foreach ($product['variants'] as  $variant) {

                $color_id = $colors[$variant['color']['name']];
                $ref = str_pad($product['id'], 4, "0", STR_PAD_LEFT) . '-' . str_pad($color_id, 3, "0", STR_PAD_LEFT);

                if (rand(0, 5)) {
                    $old_price = $product['price'];
                    $offer = fake()->randomElement([10, 20, 30, 40, 50]);
                    $price = $old_price - ($old_price * ($offer / 100));
                } else {
                    $offer = null;
                    $old_price = null;
                    $price = $product['price'];
                }
                array_push($product_variant_array, [
                    'id' => $variant['id'],
                    'ref' => $ref,
                    'old_price' => $old_price,
                    'offer' => $offer,
                    'price' => $price,
                    'img' => $variant['img'],
                    'thumb' => $variant['thumb'],
                    'max_quantity' => rand(1, 300),
                    'featured' => boolval(rand(0, 6)),
                    'color_id' => $color_id,
                    'product_id' => $product['id'],
                    'created_at' => fake()->dateTimeBetween('-2 days', 'now'),
                    'updated_at' => fake()->dateTimeBetween('-2 days', 'now'),
                ]);

                foreach ($variant['images'] as $image) {
                    array_push($images_array, [
                        'img' => $image,
                        'model_type' => 'App\Models\Product',
                        'model_id' => $variant['id'],
                    ]);
                    $this->command->info($variant['id']);
                }
            }

            if (count($product_variant_array) > 500) {
                Variant::insert($product_variant_array);
                Image::insert($images_array);
                $product_variant_array = [];
                $images_array = [];
            }
        }

        Variant::insert($product_variant_array);
        Image::insert($images_array);
    }
}
