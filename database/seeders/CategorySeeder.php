<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Specification;
use Illuminate\Database\Seeder;
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

		$categories = [
			'procesadores',
			'board',
			'gpu',
			'ram',
			'almacenamiento',
			'monitores',
			'teclados',
			'mouses',
			'torres',
			'portatiles',
			'sillas',
			'audifonos',
			'fuentes de poder',
			'combos',
			'ensambles',
		];

		foreach ($categories as $key => $value) {
			Category::factory()
				->create([
					'name' => ucfirst($value),
					'slug' => Str::slug($value),
					'img' => '/img/categories/' . Str::slug($value) . '.png',

				]);
		}
	}
}
