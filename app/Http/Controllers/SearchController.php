<?php

namespace App\Http\Controllers;


use App\Http\Resources\ProductResource;
use App\Http\Resources\Search\AttributeFilterResource;
use App\Http\Resources\Search\CategoryFilterResource;
use App\Http\Resources\Search\SearchResource;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Department;
use App\Models\Page;
use App\Models\Presentation;
use App\Models\Product;
use App\Services\SearchProductService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function search(Request $request)
    {

        // $attribute_values_id = AttributeValue::whereIn('name', ['Blanco'])->pluck('id')->toArray();

        // $presentations = Presentation::withCount([
        //     'attribute_values' => function ($query) use ($attribute_values_id) {
        //         $query->whereIn('id', $attribute_values_id);
        //     }
        // ])->get()->where('attribute_values_count', count($attribute_values_id));

        // dd($presentations->unique('product_id'));
        // 53

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
        // $filters['attributes'] = [
        //     'Color' => 'Amarillo',
        //     // 'Talla' => 'S',
        // ];
        $products_id = Product::select('id')->withFilters($filters)->get();

        $products_id_array = $products_id->pluck('id')->toArray();

        $listDepartments = Department::withCount([
            'products' =>
                function ($query) use ($products_id_array) {
                    $query->whereIn('id', $products_id_array);
                }
        ])->where('products_count', '>', 0)->get();

        $listCategories = Category::withCount([
            'products' =>
                function ($query) use ($products_id_array) {
                    $query->whereIn('id', $products_id_array);
                }
        ])->where('products_count', '>', 0)->get();

        $attributeFilter = $filters['attributes'];

        $presentations_array_id = Presentation::
            whereIn('product_id', $products_id_array)
            ->get()->unique('product_id')->pluck('id')->toArray();

        $listAttributes = Attribute::withWhereHas('attribute_values', function ($query) use ($presentations_array_id, $attributeFilter) {
            $query
                ->withCount([
                    'presentations as products_count' => function ($query) use ($presentations_array_id) {
                        $query->whereIn('id', $presentations_array_id);

                    }
                ])->where('products_count', '>', 0);

        })->get();

        // dd($listAttributes->first());

        // $searchProductService = new SearchProductService($filters);

        // $listDepartments = $searchProductService->getFilterDepartments();
        // $filters['departments'] = $listDepartments->filter(function ($department) use ($filters) {
        //     return in_array($department->name, $filters['departments']);
        // })->pluck('name')->toArray();

        // $listCategories = $searchProductService->getFilterCategories();
        // $filters['categories'] = $listCategories->filter(function ($department) use ($filters) {
        //     return in_array($department->name, $filters['categories']);
        // })->pluck('name')->toArray();

        // $listAttributes = $searchProductService->getFilterAttributes();

        // $listBrands = $searchProductService->getFilterBrands();

        $products = Product::withFilters($filters)->paginate(24)->withQueryString();

        //$breadcrumb = SearchProductService::generateBreadcrumb($filters);

        //dd($breadcrumb);

        $products_id = Product::select('id')->withFilters($filters)->get();

        return Inertia::render('Search/Search', [
            'filters' => $filters,
            'listDepartments' => CategoryFilterResource::collection($listDepartments),
            'listCategories' => CategoryFilterResource::collection($listCategories),
            'listAttributes' => AttributeFilterResource::collection($listAttributes),
            'listBrands' => [],//$listBrands,
            'products' => ProductResource::collection($products),
            'page' => $page,
            'banner' => $banner,
            //'breadcrumb' => $breadcrumb,
        ]);
    }
}
