<?php

namespace Database\Seeders;

use App\Helpers\Helpers;
use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class BrandSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Brand::truncate();
		Cache::forget('brands');
		$brands = Helpers::getAllBrands();

		$data = [];
		$faker = Faker\Factory::create();
		$current_date = date('Y-m-d H:i:s');
		foreach ($brands as $key => $value) {
			$data[$key] = [
				'name' => ucfirst($value),
				'slug' => Str::slug($value),
				'img' => '/img/brands/' . Str::slug($value) . '.png',
				'website' => $faker->url(),
				'created_at' => $current_date,
				'updated_at' => $current_date
			];
		}

		Brand::insert($data);
	}
}
