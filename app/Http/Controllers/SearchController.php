<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
	public function search(Request $request)
	{
		//sleep(2);

		$page = Page::with('banners')->where('type', 'search')->firstOrFail();
		$banner = $page->banners->where('position', 'medium')->where('type', 'banner');

		$products = Product::with('category', 'brand')
			->where(function ($query) use ($request) {
				$query->orWhere('name', 'like', "%$request->q%");
				$query->orWhere('description_max', 'like', "%$request->q%");
				$query->orWhere('description_max', 'like', "%$request->q%");
			})

			->when($request->categories, function (Builder $query) use ($request) {
				$query->whereHas('category', function (Builder $sub_query) use ($request) {
					$sub_query->whereIn('slug', $request->categories);
				});
			})

			->when($request->brands, function (Builder $query) use ($request) {
				$query->whereHas('brand', function (Builder $sub_query) use ($request) {
					$sub_query->whereIn('slug', $request->brands);
				});
			})

			->when($request->price_min, function (Builder $query) use ($request) {
				$query->where('price_offer', '>=', $request->price_min);
			})

			->when($request->price_max, function (Builder $query) use ($request) {
				$query->where('price_offer', '<=', $request->price_max);
			})

			->when($request->offer, function (Builder $query) use ($request) {
				$query->where('offer', '>=', $request->offer);
			})

			->when($request->sortBy, function (Builder $query) use ($request) {
				$sorBy = $request->sortBy == 'price_desc' ? 'desc' : 'asc';
				$query->orderBy('price_offer', $sorBy);
			}, function ($query) {
				$query->orderBy('id', 'desc');
			});


		// if ($request->category) {
		// 	//$categories = explode(',', $request->categories);
		// 	$products->whereHas('category', function (Builder $query) use ($request) {
		// 		$query->whereIn('slug', $request->categories);
		// 	});
		// }
		// if ($request->brands) {
		// 	//$brands = explode(',', $request->brands);
		// 	$products->whereHas('brand', function (Builder $query) use ($request) {
		// 		$query->whereIn('slug', $request->brands);
		// 	});
		// }
		// if ($request->price_min) {
		// 	$products->where('price', '>=', $request->price_min);
		// }
		// if ($request->price_max) {
		// 	$products->where('price', '<=', $request->price_max);
		// }
		// if ($request->offers) {
		// 	$products->where('offer', '>=', $request->offers);
		// }
		$products = $products->paginate(15)->withQueryString();

		return Inertia::render('Search/Search', [
			'filters' => $request->only([
				'q',
				'categories',
				'brands',
				'price_min',
				'price_max',
				'offer',
				'sortBy'
			]),

			'products' => ProductResource::collection($products),
			'page' => $page,
			'banner' => $banner,
		]);
		return  compact('products');
	}
}
