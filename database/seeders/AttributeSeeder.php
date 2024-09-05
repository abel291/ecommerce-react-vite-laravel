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
        Attribute::factory(5)->has(AttributeOption::factory()->count(6))->create();

        $attributeOptions = AttributeOption::get();
        $attributeOptionSelecteds = $attributeOptions->random(2);
        $attribute_option_product = [];
        foreach (Product::variant()->select('id')->get() as $key => $product) {

            foreach ($attributeOptionSelecteds as $options) {
                array_push($attribute_option_product, [
                    'product_id' => $product['id'],
                    'attribute_option_id' => $options->id
                ]);
                ;
            }

            foreach ($product['variants'] as $variant) {
                foreach ($attributeOptionSelecteds as $options) {
                    array_push($attribute_option_product, [
                        'product_id' => $variant['id'],
                        'attribute_option_id' => $options->id
                    ]);
                }
            }
            if (count($attribute_option_product) > 1000) {
                DB::table('attribute_option_product')->insert($attribute_option_product);
                $attribute_option_product = [];
                $this->command->info($key);

            }
        }
        DB::table('attribute_option_product')->insert($attribute_option_product);
    }
}
