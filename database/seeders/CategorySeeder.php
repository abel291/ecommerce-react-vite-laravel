<?php

namespace Database\Seeders;

use App\Helpers\Helpers;
use App\Models\Category;
use App\Models\Specification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Category::truncate();
		Specification::truncate();
		Cache::forget('categories');

		$department = Helpers::getAllCategories()->groupBy('department');

		foreach ($department as $name_department => $categories) {
			$name_department = Str::slug($name_department, ' ');

			$category = Category::factory()->create([
				'name' => ucfirst($name_department),
				'slug' => Str::slug($name_department, '-'),
				'img' => '/img/categories/' . Str::slug($name_department) . '.png',
				'category_id' => null,
			]);

			foreach ($categories as $item) {

				$name_category = Str::slug($item['category'], ' ');

				Category::factory()->create([
					'name' => ucfirst($name_category),
					'slug' => Str::slug($name_category, '-'),
					'img' => '/img/categories/' . Str::slug($name_category) . '.png',
					'category_id' => $category->id,
				]);
			}
		}
	}
}



// Consolas	',

// Monitores	',
// Teclados	',
// Mouses	',
// Portatiles	',
// Sillas	',
// Audifonos	',
// Mandos y accesorios	',