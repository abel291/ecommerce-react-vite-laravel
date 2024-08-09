<?php

namespace Database\Seeders;

use App\Models\Presentation;
use App\Models\Presentations;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PresentationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = 0;
        Presentation::truncate();
        DB::table('attribute_value_presentation')->truncate();
        foreach (Product::with('attributes.attribute_values')->get() as  $product) {

            $presentations_count = 1;

            foreach ($product->attributes as $attribute) {
                $presentations_count *= $attribute->attribute_values->count();
            }

            $presentation_attriubtes_array = array_fill(0, $presentations_count, []);

            foreach ($product->attributes as $attriubte_key => $attribute) {

                $multiply = $presentations_count / count($attribute->attribute_values);

                foreach ($attribute->attribute_values->multiply($multiply) as $key => $value) {

                    $presentation_attriubtes_array[$key]['id'][$attriubte_key] = $value->id;
                    $presentation_attriubtes_array[$key]['value'][$attriubte_key] = $value->value;
                }
            }

            foreach ($presentation_attriubtes_array as  $presentation_attriubte_array) {

                $presentation = Presentation::create([
                    'product_id' => $product->id,
                    'stock' => rand(2, 10) * 12,
                    'code' => Str::padLeft($count, 6, '0'),
                    'value' => $presentation_attriubte_array ? implode('-', $presentation_attriubte_array['value']) : null
                ]);
                if ($presentation_attriubte_array) {
                    $presentation->attribute_values()->attach($presentation_attriubte_array['id']);
                }
                $this->command->info($count++ . '-' . $presentation->code);
            }
        }
    }
}
