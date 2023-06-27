<?php

namespace App\Services;

use App\Contracts\CheckoutInterface;
use App\Enums\CartEnum;
use App\Enums\DiscountCodeTypeEnum;
use App\Models\Brand;
use App\Models\Category;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;

use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Database\Eloquent\Builder;

class SearchProductService
{



	public static function getFilterDepartment($filters)
	{
		$filters['department'] = [];
		//if ($filters['category']) {
		if (false) {
			return [];
		} else {
			$departments = Category::select('id', 'name', 'slug')->whereNull('category_id')->where('type', 'product')
				->where('active', 1)
				->withCount(['department_products as products_count' => function ($query) use ($filters) {
					$query->withFilters($filters);
				}])
				->whereHas('department_products', function ($query) use ($filters) {
					$query->withFilters($filters);
				})
				->with('categories')
				->get();
			return $departments;
		}
	}

	public static function getFilterCategories($filters)
	{

		// if ($filters['department']) {
		if (true) {
			$filters['category'] = [];
			$categries = Category::select('id', 'name', 'slug')->where('type', 'product')
				->where('active', 1)
				->withCount(['products' => function ($query) use ($filters) {
					$query->withFilters($filters);
				}])
				->whereHas('products', function ($query) use ($filters) {
					$query->withFilters($filters);
				})
				->get();
			return $categries;
		} else {
			return [];
		}
	}


	public static function getFilterBrands($filters)
	{
		$filters['brands'] = [];
		//dd($filters);
		$brands = Brand::where('active', 1)
			->select('id', 'name', 'slug')
			->withCount(['products' => function ($query) use ($filters) {
				$query->withFilters($filters);
			}])
			->whereHas('products', function ($query) use ($filters) {
				$query->withFilters($filters);
			})
			->orderBy('name')
			->get();

		return $brands;
	}

	public static function generateBreadcrumb($filters)
	{

		$breadcrumb = [];

		$categories_slug = [...$filters['department'], ...$filters['category']];

		$categories = Category::select('id', 'name', 'slug')->whereActive(1)->whereIn('slug', $categories_slug)->get();

		$data = [
			'department' => $categories->whereIn('slug', $filters['department']),
			'category' => $categories->whereIn('slug', $filters['category']),
			'brands' => Brand::select('id', 'name', 'slug')->whereActive(1)->whereIn('slug', $filters['brands'])->get()
		];

		foreach ($data as $key => $items) {
			foreach ($items as $key => $item) {
				$breadcrumb[] = [
					'title' => $item->name,
					'path' => route('search', [$key => $item->slug]),
				];
			}
		}

		return $breadcrumb;
	}
}
