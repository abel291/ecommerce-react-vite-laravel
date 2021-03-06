<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Faker as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();
        Image::truncate();

        $faker = Faker\Factory::create();
        foreach (Category::get() as $category) {
            for ($i = 0; $i < 10; $i++) {
                $name = $category->name.' '.$faker->words(4, true);

                Product::factory()

                    ->has(Image::factory()->count(3)->state(function (array $attributes) use ($category) {
                        return ['img' => $category->slug.'/'.$category->slug.'-'.rand(1, 10).'.jpg'];
                    }))

                    ->create([
                        'name' => ucfirst($name),
                        'slug' => Str::slug($name),
                        'img' => $category->slug.'/'.$category->slug.'-'.($i + 1).'.jpg',
                        'category_id' => $category->id,
                    ]);
            }
        }
    }
}
