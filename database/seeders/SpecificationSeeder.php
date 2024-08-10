<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Specification;
use App\Models\SpecificationValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SpecificationSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		Specification::truncate();
		SpecificationValue::truncate();

		$products = collect(Storage::json(DatabaseSeeder::getPathProductJson()));
		// dd($product['id']);

		foreach ($products as  $product) {

			$this->command->info($product['id']);
		}

		// dd(count($specifications_array));

		// foreach (array_chunk($specifications_array, 1) as  $value) {
		//     Specification::insert($value);
		// }
		// foreach (array_chunk($specification_values, 1) as  $value) {
		//     SpecificationValue::insert($value);
		// }
	}
}
