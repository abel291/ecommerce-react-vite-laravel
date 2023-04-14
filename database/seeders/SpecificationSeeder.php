<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Specification;
use Illuminate\Database\Seeder;
use Faker;
use Symfony\Component\CssSelector\Node\Specificity;
use Illuminate\Support\Str;

class SpecificationSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Specification::truncate();
		$faker = Faker\Factory::create();
		$specifications = [];
		$current_date = date('Y-m-d H:i:s');
		foreach (Category::with('products')->get() as $category) {
			foreach ($category->products as $product) {
				foreach ($category->specifications as $name_specification) {

					array_push($specifications, [
						'name' => $name_specification,
						'slug' => Str::slug($name_specification),
						'value' => $faker->words(3, true),
						'product_id' => $product->id,
						'created_at' => $current_date,
						'updated_at' => $current_date
					]);
				}
			}
		}
		Specification::insert($specifications);
	}
}
