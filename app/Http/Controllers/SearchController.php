<?php

namespace App\Http\Controllers;

use App\Http\Resources\AttributeResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\Search\AttributeFilterResource;
use App\Http\Resources\Search\CategoryFilterResource;
use App\Http\Resources\Search\SearchResource;
use App\Models\Page;
use App\Models\Product;
use App\Services\SearchProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        //Cache::flush();
        $page = Page::with('banners')->where('type', 'search')->firstOrFail();

        $banner = $page->banners->where('position', 'middle')->where('type', 'banner');

        $filters = [
            'q' => $request->input('q', null),
            'departments' => $request->input('departments', []),
            'categories' => $request->input('categories', []),
            'price_min' => $request->input('price_min', ''),
            'price_max' => $request->input('price_max', ''),
            'brands' => $request->input('brands', []),
            'offer' => $request->input('offer', ''),
            'sortBy' => $request->input('sortBy', ''),
            'attributes' => $request->input('attributes', []),
        ];

        $searchProductService = new SearchProductService($filters);

        $listDepartments = $searchProductService->getFilterDepartments();

        $listCategories = $searchProductService->getFilterCategories();

        $listAttributes = $searchProductService->getFilterAttributes();

        $listBrands = $searchProductService->getFilterBrands();

        $products = Product::withFilters($filters)->paginate(24)->withQueryString();

        //$breadcrumb = SearchProductService::generateBreadcrumb($filters);

        //dd($breadcrumb);
        return Inertia::render('Search/Search', [
            'filters' => $filters,
            'listDepartments' => CategoryFilterResource::collection($listDepartments),
            'listCategories' => CategoryFilterResource::collection($listCategories),
            'listAttributes' => AttributeFilterResource::collection($listAttributes),
            'listBrands' => $listBrands,
            'products' => ProductResource::collection($products),
            'page' => $page,
            'banner' => $banner,
            //'breadcrumb' => $breadcrumb,
        ]);
    }
}
