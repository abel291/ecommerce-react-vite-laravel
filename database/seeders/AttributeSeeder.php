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
        Attribute::factory(5)->has(AttributeOption::factory()->count(6))->create();

        $attributeOptions = AttributeOption::get();
        $attribute_option_product = [];
        foreach (Product::select('id')->get() as $produc) {

            foreach ($attributeOptions->random(4) as $options) {
                $attribute_option_product[] = [
                    'product_id' => $produc['id'],
                    'attribute_option_id' => $options->id
                ];
            }
        }
        DB::table('attribute_option_product')->insert($attribute_option_product);
    }
}
