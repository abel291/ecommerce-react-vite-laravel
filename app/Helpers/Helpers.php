<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class Helpers
{
	public static function getAllProducts()
	{
		return self::joinJson();
	}

	public static function getAllCategories()
	{
		return self::joinJson()->unique('category')->map(function ($item) {
			return [
				'department' => $item['department'],
				'category' => $item['category'],
			];
		});
	}
	public static function getAllBrands()
	{
		return self::joinJson()->unique('brand')->pluck('brand');
	}

	public static function joinJson()
	{
		$products_files = Storage::allFiles('products_data');

		$products = [];
		foreach ($products_files as $json_path) {
			$products[] = Storage::json($json_path);
		}

		return collect($products)->collapse()->unique('name');
	}
}
