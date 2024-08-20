<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Attribute\ColorAttribute;
use App\Models\Attribute\SizeAttribute;
use App\Models\AttributeValue;
use App\Models\Presentation;
use App\Models\Presentations;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// use Illuminate\Support\Str;

class PresentationAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $products = collect(Storage::json(DatabaseSeeder::getPathProductJson()));

        Presentation::truncate();

        $colors_model = ColorAttribute::pluck('id', 'name');
        $sizes_model = SizeAttribute::pluck('id', 'name');
        $colors_names = $colors_model->keys();
        $presentations_array = [];

        $presentation_count = 0;

        foreach ($products as  $product) {
            $colors = [];
            $sizes = [];
            $product_id = $product['id'];

            foreach ($product['attributes'] as  $attribute) {
                match ($attribute['name']) {
                    'Color' => $colors = [...$attribute['value'], ...$colors_names->random(rand(1, 4))->toArray()],
                    'Talla' => $sizes = $attribute['value'],
                };
            }

            foreach ($colors as   $color) {
                $presentation = [
                    'product_id' => $product_id,
                    'color_attribute_id' => $colors_model[$color],
                ];
                foreach ($sizes as $key => $size) {
                    $presentations_array[] = [
                        ...$presentation,
                        'name' => "$color - $size",
                        'size_attribute_id' => $sizes_model[$size],
                        'default' => $key == 0,
                        'code' => $product_id . $key . $presentation_count++,
                        'stock' => rand(0, 1) * rand(10, 300),
                    ];
                }
            }
        }

        foreach (array_chunk($presentations_array, 300) as $key => $presentation) {
            Presentation::insert($presentation);
        }
    }
}
