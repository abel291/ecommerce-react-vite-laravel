<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryFiltersResource;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Observers\CategoryObserver;
use App\Services\SearchProductService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class SearchController extends Controller
{
	public function search(Request $request)
	{
		//Cache::flush();
		$page = Page::with('banners')->where('type', 'search')->firstOrFail();

		$banner = $page->banners->where('position', 'middle')->where('type', 'banner');

		$filters = [
			'q' => $request->input('q', null),
			'department' => $request->input('department', []),
			'category' => $request->input('category', []),
			'price_min' => $request->input('price_min', ""),
			'price_max' => $request->input('price_max', ""),
			'brands' => $request->input('brands', []),
			'offer' => $request->input('offer', ""),
			'sortBy' => $request->input('sortBy', "")
		];
		$searchProductService = new SearchProductService($filters);
		//dd(boolval(count([])));

		$list_departments = SearchProductService::getFilterDepartment($filters);

		$filters['department'] = $list_departments->whereIn('slug', $filters['department'])->pluck('slug')->values()->toArray();

		$list_categories = SearchProductService::getFilterCategories($filters);

		$filters['category'] = $list_categories->whereIn('slug', $filters['category'])->pluck('slug')->values()->toArray();

		$brands = SearchProductService::getFilterBrands($filters);

		$filters['brands'] = $brands->whereIn('slug', $filters['brands'])->pluck('slug')->values()->toArray();

		$products = Product::withFilters($filters)->paginate(15)->withQueryString();

		$breadcrumb = SearchProductService::generateBreadcrumb($filters);

		//dd($breadcrumb);
		return Inertia::render('Search/Search', [
			'filters' => $filters,
			'products' => ProductResource::collection($products),
			'page' => $page,
			'list_departments' => CategoryFiltersResource::collection($list_departments),
			'list_categories' => CategoryFiltersResource::collection($list_categories),
			'brands' => CategoryFiltersResource::collection($brands),
			'banner' => $banner,
			'breadcrumb' => $breadcrumb,
		]);
	}
}
