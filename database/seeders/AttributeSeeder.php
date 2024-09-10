<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Author;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker;
use Illuminate\Support\Facades\DB;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Attribute::truncate();
        AttributeOption::truncate();
        DB::table('attribute_option_product')->truncate();
        Attribute::factory(5)->has(AttributeOption::factory()->count(6), 'attribute_options')->create();

        $attributeOptions = AttributeOption::pluck('id')->toArray();
        // $attributesOptionSelected = $attributeOptions->random(2)->toArray();
        $attribute_option_product = [];
        foreach (Product::variant()->select('id')->get() as $key => $product) {

            $attributesOptionSelected = array_rand($attributeOptions, rand(3, 5));

            foreach ($attributesOptionSelected as $options_id) {
                array_push($attribute_option_product, [
                    'product_id' => $product['id'],
                    'attribute_option_id' => $options_id
                ]);;
            }

            foreach ($product['variants'] as $variant) {
                foreach ($attributesOptionSelected as $options_id) {
                    array_push($attribute_option_product, [
                        'product_id' => $variant['id'],
                        'attribute_option_id' => $options_id
                    ]);
                }
            }
            if (count($attribute_option_product) > 500) {
                DB::table('attribute_option_product')->insert($attribute_option_product);
                $attribute_option_product = [];
                $this->command->info($key);
            }
        }
        DB::table('attribute_option_product')->insert($attribute_option_product);
    }
}
