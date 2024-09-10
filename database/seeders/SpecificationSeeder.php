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
        // $products = Product::pluck('id')->toArray();

        $products = collect(Storage::json(DatabaseSeeder::getPathProductJson()))->shuffle();

        $specification_id = 1;
        $specifications_array = [];
        $specifications_value_array = [];
        foreach ($products as $product) {
            foreach ($product['specifications'] as $specification) {

                array_push($specifications_array, [
                    'id' => $specification_id,
                    'name' => $specification['title'],
                    'product_id' => $product['id'],
                ]);
                foreach ($specification['values'] as $specification_value) {
                    array_push($specifications_value_array, [
                        'specification_id' => $specification_id,
                        'name' => $specification_value['title'],
                        'value' => $specification_value['values'],

                    ]);
                }
                $specification_id++;

                foreach ($product['variants'] as $variant) {
                    array_push($specifications_array, [
                        'id' => $specification_id,
                        'name' => $specification['title'],
                        'product_id' => $variant['id'],

                    ]);
                    foreach ($specification['values'] as $specification_value) {
                        array_push($specifications_value_array, [
                            'specification_id' => $specification_id,
                            'name' => $specification_value['title'],
                            'value' => $specification_value['values'],

                        ]);
                    }
                    $specification_id++;
                }

            }

            if (count($specifications_value_array) > 200) {
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
    public function insertData()
    {

    }
}
