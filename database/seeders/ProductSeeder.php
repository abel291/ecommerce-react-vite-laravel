<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Specification;
use App\Models\Stock;
use Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
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
		$brands = Brand::get()->pluck('id', 'name');
		$categories = Category::get()->pluck('id', 'slug');
		//dd($categories);

		$products_json = collect(Storage::json('products_with_images.json'));


		$faker = Faker\Factory::create();
		foreach ($products_json as $key => $product) {

			$category = Str::slug($product['category'], '-');
			$category = $categories[$category];
			$brand = $brands[$product['brand']];

			$price = $product['price'];

			$offer = $faker->randomElement([0, 10, 20, 30, 40, 50]);

			$price_offer = $price - ($price * ($offer / 100));

			$cost = round($price * 0.80);

			$product_factory = Product::factory()
				// ->has(Image::factory()->count(5)->state(function (array $attributes) use ($category) {
				// 	return ['img' => '/img/categories/' . $category->slug . '/' . $category->slug . '-' . rand(1, 10) . '.jpg',];
				// }))
				->has(Stock::factory()->count(1))
				->create([
					'name' => $product['title'],
					'slug' => Str::slug($product['title'], '-') . "-" . rand(1000, 2002),
					'img' => $product['images'][0]['new_image'],
					'thum' => $product['images'][0]['new_image_thumb'],
					'description_max' => $product['desc'],
					'price' => $price,
					'offer' => $offer,
					'price_offer' => $price_offer,
					'cost' => $cost,
					'category_id' => $category,
					'brand_id' => $brand,
				]);

			$images = collect($product['images'])->slice(1)->map(function ($item) {

				return [
					'img' => $item['new_image'],
					'thumb' => $item['new_image_thumb'],
				];
			});

			$product_factory->images()->createMany($images);
		}


		// foreach (Category::where('type', 'product')->get() as $category) {

		// 	for ($i = 0; $i < 40; $i++) {
		// 		$name = $category->name . ' ' . $faker->words(7, true);

		// 		Product::factory()
		// 			->has(Image::factory()->count(5)->state(function (array $attributes) use ($category) {
		// 				return ['img' => '/img/categories/' . $category->slug . '/' . $category->slug . '-' . rand(1, 10) . '.jpg',];
		// 			}))
		// 			->has(Stock::factory()->count(1))
		// 			->create([
		// 				'name' => ucfirst($name),
		// 				'slug' => Str::slug($name) . "-" . rand(100, 200),
		// 				'img' => '/img/categories/' . $category->slug . '/' . $category->slug . '-' . rand(1, 10) . '.jpg',
		// 				'thum' => '/img/categories/' . $category->slug . '/' . $category->slug . '-' . rand(1, 10) . '.jpg',
		// 				'category_id' => $category->id,
		// 				'brand_id' => $brands->random()->id,
		// 			]);
		// 	}
		// }
	}
}
