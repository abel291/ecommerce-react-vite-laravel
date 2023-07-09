<?php

namespace Database\Seeders;

use App\Helpers\Helpers;
use App\Models\Category;
use App\Models\Department;
use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{

		Cache::flush();
		Schema::disableForeignKeyConstraints();

		Image::truncate();
		$this->call([

			UserSeeder::class,
			PageSeeder::class,
			CategorySeeder::class,
			//SpecificationSeeder::class,
			BrandSeeder::class,
			BlogSeeder::class,
			ProductSeeder::class,

			// ShoppingCartSeeder::class,
			// OrderSeeder::class,
			// BlogSeeder::class,
		]);
		Schema::enableForeignKeyConstraints();
	}
}
