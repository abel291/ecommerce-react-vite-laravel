<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Specification;
use App\Models\Stock;
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
		Stock::truncate();
		$brands = Brand::all();
		$faker = Faker\Factory::create();
		foreach (Category::where('type', 'product')->get() as $category) {

			for ($i = 0; $i < 10; $i++) {
				$name = $category->name . ' ' . $faker->words(3, true);

				Product::factory()
					->has(Image::factory()->count(12)->state(function (array $attributes) use ($category) {
						return ['img' => '/img/categories/' . $category->slug . '/' . $category->slug . '-' . rand(1, 10) . '.jpg',];
					}))
					->has(Stock::factory()->count(1))
					->create([
						'name' => ucfirst($name),
						'slug' => Str::slug($name) . rand(100, 200),
						'img' => '/img/categories/' . $category->slug . '/' . $category->slug . '-' . rand(1, 10) . '.jpg',
						'thum' => '/img/categories/' . $category->slug . '/' . $category->slug . '-' . rand(1, 10) . '.jpg',
						'category_id' => $category->id,
						'brand_id' => $brands->random()->id,
					]);
			}
		}
	}
}
