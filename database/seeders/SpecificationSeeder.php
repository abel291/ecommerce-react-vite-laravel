<?php

namespace Database\Seeders;

use App\Helpers\Helpers;
use App\Models\Category;
use App\Models\Specification;
use Faker;
use Illuminate\Database\Seeder;
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
		$current_date = date('Y-m-d H:i:s');

		Specification::truncate();
		$data = Helpers::getAllProducts();
		$specifications = $data->pluck('specifications')->collapse()->unique('title')->map(function ($item) use ($current_date) {
			return [
				'type' => $item['title'],
				'slug' => Str::slug($item['title']),
				'active' => 1,
				'created_at' => $current_date,
				'updated_at' => $current_date
			];
		})->values()->toArray();

		Specification::insert($specifications);
	}
}
