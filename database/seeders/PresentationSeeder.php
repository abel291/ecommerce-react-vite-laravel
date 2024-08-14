<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Presentation;
use App\Models\Presentations;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

// use Illuminate\Support\Str;

class PresentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Presentation::truncate();
        DB::table('attribute_value_presentation')->truncate();

        // Attribute::truncate();
        // AttributeValue::truncate();
        $attributes_value_model = AttributeValue::pluck('id', 'name');

        $products = Product::pluck('id')->toArray();

        $products = collect(Storage::json(DatabaseSeeder::getPathProductJson()))->whereIn('id', $products)->pluck('attributes', 'id');

        $presentation_id = 0;
        $presentation_array = [];
        $attribute_value_presentation = [];
        foreach ($products as $product_id => $attributes) {


            $presentations_count = array_reduce($attributes, function ($carry, $attribute) {
                return $carry * count($attribute['value']);
            }, 1);

            $presentation_attriubtes_array = array_fill(0, $presentations_count, []);

            foreach ($attributes as $attriubte_key => $attribute) {

                $multiply = $presentations_count / count($attribute['value']);

                foreach (collect($attribute['value'])->multiply($multiply) as $key => $value) {
                    $attriubte_value_id = $attributes_value_model[$value];
                    $presentation_attriubtes_array[$key]['id'][$attriubte_key] = $attriubte_value_id;
                    $presentation_attriubtes_array[$key]['value'][$attriubte_key] = $value;
                }
            }

            foreach ($presentation_attriubtes_array as $key => $presentation_attriubte_array) {
                $presentation_id++;
                $presentation_array[] = [
                    'id' => $presentation_id,
                    'product_id' => $product_id,
                    'stock' => rand(1, 12) * 12,
                    'code' => $product_id . $key,
                    'name' => null
                ];
                if ($presentation_attriubte_array) {
                    foreach ($presentation_attriubte_array['id'] as $key => $attriubte_value_id) {
                        $attribute_value_presentation[] = [
                            'presentation_id' => $presentation_id,
                            'attribute_value_id' => $attriubte_value_id,
                        ];
                    }
                }
                $this->command->info($product_id . '-' . $presentation_id);
            }

            if (count($presentation_array) > 500) {
                Presentation::insert($presentation_array);
                $presentation_array = [];

                if ($attribute_value_presentation) {
                    DB::table('attribute_value_presentation')->insert($attribute_value_presentation);
                    $attribute_value_presentation = [];
                }
            }

        }

        Presentation::insert($presentation_array);
        DB::table('attribute_value_presentation')->insert($attribute_value_presentation);


    }
}
