<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Author;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sku;

use Illuminate\Database\Seeder;
use Faker;
use Illuminate\Support\Facades\Storage;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sku::truncate();

        foreach (Product::with('attributes.attribute_values') as $key => $product) {
        }
    }
}
