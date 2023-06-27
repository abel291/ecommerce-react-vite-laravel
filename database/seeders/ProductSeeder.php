<?php

namespace Database\Seeders;

use App\Helpers\Helpers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Specification;
use App\Models\Stock;
use Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
		DB::table('category_product')->truncate();
		$brands = Brand::get();

		$categories = Category::select('id', 'name', 'slug')->get();

		$products = Helpers::getAllProducts();

		$products = $products->shuffle();

		$faker = Faker\Factory::create();


		foreach ($products as $key => $product) {

			$category_slug = Str::slug($product['category']);

			$department_slug = Str::slug($product['department']);

			$department = $categories->firstWhere('slug', $department_slug);

			$category = $categories->firstWhere('slug', $category_slug);

			$brand = $brands->firstWhere('slug', Str::slug($product['brand']));

			$price = $product['price'];

			$offer = $faker->randomElement([0, 10, 20, 30, 40, 50]);

			$price_offer = $price - ($price * ($offer / 100));

			$cost = round($price * 0.80);

			echo ($key + 1) . " - " . $product['name'] . " \n";

			$product_factory = Product::factory()
				->has(Stock::factory()->count(1))
				->create([
					'name' => $product['name'],
					'slug' => Str::slug($product['name'], '-') . "-" . rand(1000, 2002),
					'img' => $product['img'],
					'thumb' => $product['thumb'],
					//'description_min' => $product['entry'],
					'description_max' => $product['desc'],
					'price' => $price,
					'offer' => $offer,
					'price_offer' => $price_offer,
					'cost' => $cost,
					'department_id' => $department->id,
					'category_id' => $category->id,
					'sub_category_id' => null,
					'brand_id' => $brand->id,
				]);

			$images = collect($product['images'])->map(function ($item) {

				return [
					'img' => $item['img'],
					'thumb' => $item['thumb'],
				];
			});

			$product_factory->images()->createMany($images);

			$product_factory->specifications()->createMany($product['specifications']);
		}
	}
}
