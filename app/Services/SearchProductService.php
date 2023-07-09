<?php

namespace App\Services;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Department;

class SearchProductService

{
	public $filters = [];
	public function __construct(array $filters)
	{
		$this->filters = $filters;
	}
	public static function getFilterDepartment($filters)
	{
		$filters['department'] = [];
		$departments = Department::select('id', 'name', 'slug')
			->active()
			->withCount(['products' => function ($query) use ($filters) {
				$query->withFilters($filters);
			}])
			->whereHas('products', function ($query) use ($filters) {
				$query->withFilters($filters);
			})

			->get();

		return $departments;
	}

	public static function getFilterCategories($filters)
	{
		//
		$filters['category'] = [];
		$categories = Category::select('id', 'name', 'slug')->where('type', 'product')
			->active()
			->withCount(['products' => function ($query) use ($filters) {
				$query->withFilters($filters);
			}])
			->whereHas('products', function ($query) use ($filters) {
				$query->withFilters($filters);
			})
			->get();

		return $categories;
	}
	public static function getFilterAttributes($filters)
	{

		$filters['attribute_values'] = [];
		$attributes = Attribute::select('id', 'name', 'slug')->with(['attribute_values' => function ($query1) use ($filters) {
			$query1
				->select('id', 'attribute_id', 'name', 'slug')
				->withCount(['products' => function ($query2) use ($filters) {
					$query2->withFilters($filters);
				}])
				->whereHas('products', function ($query3) use ($filters) {
					$query3->withFilters($filters);
				})
				//->orderBy('slug', 'asc')
				->orderBy('products_count', 'desc')
				->limit(20);
		}])->get();


		return $attributes;
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
			'brands' => Brand::select('id', 'name', 'slug')->whereActive(1)->whereIn('slug', $filters['brands'])->get(),
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
