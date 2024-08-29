<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Attribute\ColorAttribute;
use App\Models\Attribute\SizeAttribute;
use App\Models\AttributeOption;
use App\Models\AttributeValue;
use App\Models\Color;
use App\Models\Image;
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
        Variant::truncate();
        DB::table('size_variant')->truncate();
        Image::where('model_type', 'App\Models\Variant')->delete();

        $products = collect(Storage::json(DatabaseSeeder::getPathProductJson()));
        $colors = Color::pluck('id', 'name');
        $sizes = Size::pluck('id', 'name');
        // dd($colors->sortKeys());
        $variant_id = 0;
        $variant_array = [];
        $size_variant_array = [];
        $images_array = [];
        foreach ($products as $key => $product) {
            foreach ($product['colors'] as $key => $color) {
                $color_id = $colors[$color['color']['name']];
                $ref = str_pad($product['id'], 4, "0", STR_PAD_LEFT) . '-' . str_pad($color_id, 3, "0", STR_PAD_LEFT);

                array_push($variant_array, [
                    'id' => $variant_id,
                    'ref' =>  $ref,
                    'default' => $key == 0,
                    'color_id' => $color_id,
                    'product_id' => $product['id'],
                    'img' => $color['img'],
                    'thumb' => $color['thumb'],
                    'created_at' => fake()->dateTimeBetween('-2 days', 'now'),
                    'updated_at' => fake()->dateTimeBetween('-2 days', 'now'),
                ]);

                foreach ($color['images'] as $image) {
                    array_push($images_array, [
                        'img' => $image,
                        'model_type' => 'App\Models\Variant',
                        'model_id' => $variant_id,

                    ]);
                }
                foreach ($product['sizes'] as $size) {
                    array_push($size_variant_array, [
                        'stock' => rand(0, 1) * rand(10, 300),
                        'product_id' => $product['id'],
                        'variant_id' => $variant_id,
                        'size_id' => $sizes[$size],

                    ]);
                }
                $variant_id++;
            }



            if (count($variant_array) > 500) {
                Variant::insert($variant_array);
                Image::insert($images_array);
                DB::table('size_variant')->insert($size_variant_array);
                $variant_array = [];
                $size_variant_array = [];
                $images_array = [];
                $this->command->info($product['id']);
            }
        }
        // dd(collect($variant_array)->duplicates('ref'));


        Variant::insert($variant_array);
        Image::insert($images_array);
        DB::table('size_variant')->insert($size_variant_array);
    }
}
