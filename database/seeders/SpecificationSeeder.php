<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\Specification;
use App\Models\SpecificationValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SpecificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Specification::truncate();
        SpecificationValue::truncate();
        $products = Product::pluck('id')->toArray();

        $products = collect(Storage::json(DatabaseSeeder::getPathProductJson()))->whereIn('id', $products);
        $specifications = $products->map(function ($product) {


            return collect($product['specifications'])->map(function ($specification) use ($product) {

                return [
                    'product_id' => $product['id'],
                    ...$specification
                ];
            });
        })->collapse()->values();

        $specifications_array = [];
        $specifications_value_array = [];

        foreach ($specifications as $key => $specification) {
            $specification_id = $key + 1;

            array_push($specifications_array, [
                'id' => $specification_id,
                'name' => $specification['title'],
                'product_id' => $specification['product_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($specification['table'] as $specification_value) {
                array_push($specifications_value_array, [
                    ...$specification_value,
                    'specification_id' => $specification_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if (count($specifications_value_array) > 300) {
                Specification::insert($specifications_array);
                SpecificationValue::insert($specifications_value_array);
                $specifications_array = [];
                $specifications_value_array = [];
                // $this->command->info("Specification " . $specification_id);
            }

        }
        Specification::insert($specifications_array);
        SpecificationValue::insert($specifications_value_array);
    }
}
