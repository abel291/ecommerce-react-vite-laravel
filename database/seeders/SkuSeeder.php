<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SkuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = 0;
        Sku::truncate();
        DB::table('attribute_value_sku')->truncate();
        foreach (Product::with('attributes.attribute_values')->get() as  $product) {

            $skus_count = 1;

            foreach ($product->attributes as $attribute) {
                $skus_count *= $attribute->attribute_values->count();
            }
            $skus_array = array_fill(0, $skus_count, []);

            foreach ($product->attributes as $attriubte_key => $attribute) {

                $multiply = $skus_count / count($attribute->attribute_values);

                foreach ($attribute->attribute_values->multiply($multiply) as $key => $value) {

                    $skus_array[$key][$attriubte_key] = $value->id;
                }
            }
            foreach ($skus_array as  $array_attribute_values) {
                $sku = Sku::create([
                    'product_id' => $product->id,
                    'quantity' => rand(2, 10) * 12,
                    'code' => Str::padLeft($count, 6, '0')
                ]);
                $sku->attribute_values()->attach($array_attribute_values);
                $this->command->info($count++ . '-' . $sku->code);
            }
        }
    }
}
