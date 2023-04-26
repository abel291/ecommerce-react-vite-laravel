<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Faker as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		Schema::disableForeignKeyConstraints();

		Image::truncate();
		$this->call([
			UserSeeder::class,
			PageSeeder::class,
			BannerSeeder::class,
			CategorySeeder::class,
			BrandSeeder::class,
			ProductSeeder::class,
			SpecificationSeeder::class,
			ShoppingCartSeeder::class,
			OrderSeeder::class,
			BlogSeeder::class
		]);
		Schema::enableForeignKeyConstraints();
	}
}
