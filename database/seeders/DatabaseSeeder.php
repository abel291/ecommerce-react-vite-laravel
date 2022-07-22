<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('product_specification')->truncate();
        $this->call([
            CategorySeeder::class,
            UserSeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
            CardProductSeeder::class,
            OrderSeeder::class,
        ]);
        $faker = Faker\Factory::create();

        foreach (Product::with('category', 'category.specifications')->get() as $key => $product) {
            $category = $product->category;
            $data_product_specification = [];
            foreach ($category->specifications as $key => $specification) {
                $data_product_specification[$key] = [
                    'specification_id' => $specification->id,
                    'product_id' => $product->id,
                    'value' => $faker->words(2, true),
                ];
            }
            DB::table('product_specification')->insert($data_product_specification);
        }

        Schema::enableForeignKeyConstraints();
    }
}
