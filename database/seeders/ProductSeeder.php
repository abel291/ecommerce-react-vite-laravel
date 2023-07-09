<?php

namespace Database\Seeders;

use App\Helpers\Helpers;
use App\Models\Attribute;
use App\Models\AttributeProduct;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Department;
use App\Models\Product;

use App\Models\Specification;

use App\Models\Stock;
use Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
		Specification::truncate();
		Attribute::truncate();
		AttributeProduct::truncate();

		$brands = Brand::get();
		$categories = Category::select('id', 'name', 'slug')->get();
		$departments = Department::select('id', 'name', 'slug')->get();

		$products = Helpers::getAllProducts();

		$faker = Faker\Factory::create();

		foreach ($products as $key => $product) {

			$category_slug = Str::slug($product['category']);

			$department_slug = Str::slug($product['department']);

			$department = $departments->firstWhere('slug', $department_slug);

			$category = $categories->firstWhere('slug', $category_slug);

			$brand = $brands->firstWhere('slug', Str::slug($product['brand']));

			$price = $product['price'];

			$offer = rand(0, 1) ? $faker->randomElement([10, 20, 30, 40, 50]) : 0;

			$price_offer = $price - ($price * ($offer / 100));

			$cost = round($price * 0.80);

			echo ($key + 1) . ' - ' . $product['name'] . " \n";

			$product_factory = Product::factory()
				->has(Stock::factory()->count(1))
				->create([
					'name' => $product['name'],
					'slug' => Str::slug($product['name'], '-'),
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

			$product_factory->images()->createMany($product['images']);
			$specifications = [];
			foreach ($product['specifications'] as $key => $item) {

				foreach ($item['table'] as $key => $table) {
					array_push($specifications, [
						'type' => $item['title'],
						'name' => $table['name'],
						'slug' => Str::slug($table['name']),
						'value' => $table['value'],
						'active' => 1,
					]);
				}
			}
			$product_factory->specifications()->createMany($specifications);
			self::addAttribute($product_factory, $product['attributes']);
		}
	}
	public static function addAttribute($product, $attributes_array)
	{

		foreach ($attributes_array as  $item) {
			$attribute_selected = Attribute::firstOrCreate([
				'name' => $item['name'],
				'slug' => Str::slug($item['name']),
			]);

			foreach ($item['value'] as $value) {
				$attribute_value = AttributeValue::firstOrCreate([
					'name' => $value,
					'slug' => Str::slug($value),
					'attribute_id' => $attribute_selected->id,
				]);

				$product->attributes()->attach($attribute_selected->id, [
					'attribute_value_id' => $attribute_value->id,
				]);
			}
		}
	}
}
