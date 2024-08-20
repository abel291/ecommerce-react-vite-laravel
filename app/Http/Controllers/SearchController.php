<?php

namespace App\Http\Controllers;

use App\Http\Resources\ColorAttributeResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\Search\AttributeFilterResource;
use App\Http\Resources\Search\CategoryFilterResource;
use App\Http\Resources\Search\SearchResource;
use App\Http\Resources\SizeAttributeResource;
use App\Models\Attribute;
use App\Models\Attribute\ColorAttribute;
use App\Models\Attribute\SizeAttribute;
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
        // dd(Department::select('id', 'name', 'slug', 'img', 'icon')
        //     ->active()
        //     ->with(['categories' => function ($query) {
        //         $query->active();
        //     }])

        //     ->get());

        // Cache::flush();
        $page = Page::with('banners')->where('type', 'search')->firstOrFail();

        $banner = $page->banners->where('position', 'middle')->where('type', 'banner');

        $filters = [
            'q' => $request->input('q', null),
            'departments' => $request->input('departments', []),
            'categories' => $request->input('categories', []),
            'colors' => $request->input('colors', []),
            'sizes' => $request->input('sizes', []),
            'attributes' => [],
            'price_min' => $request->input('price_min', ''),
            'price_max' => $request->input('price_max', ''),
            'brands' => $request->input('brands', []),
            'offer' => $request->input('offer', ''),
            'sortBy' => $request->input('sortBy', ''),
            'attributes' => $request->input('attributes', []),
        ];
        // dd($filters);
        // $filters['attributes'] = [
        //     'Color' => 'Amarillo',
        //     // 'Talla' => 'S',
        // ];
        // $products_id = Product::select('id')->withFilters($filters)->get();

        // $products_id_array = $products_id->pluck('id')->toArray();

        $listDepartments = Department::whereHas(
            'products',
            function ($query) use ($filters) {
                $query->withFilters([
                    ...$filters,
                    'departments' => []
                ]);
            }
        )->get();


        $listCategories = Category::whereHas(
            'products',
            function ($query) use ($filters) {
                $query->withFilters([
                    ...$filters,
                    'categories' => []
                ]);
            }
        )->get();

        $listColors = ColorAttribute::whereHas(
            'products',
            function ($query) use ($filters) {
                $query->withFilters([
                    ...$filters,
                    'colors' => []
                ]);
            }
        )->orderBy('slug')->get();

        $listSizes = SizeAttribute::whereHas(
            'products',
            function ($query) use ($filters) {
                $query->withFilters([
                    ...$filters,
                    'sizes' => []
                ]);
            }
        )->orderBy('slug')->get();

        $products = Product::selectForCard()->withFilters($filters)->paginate(24)->withQueryString();

        // $breadcrumb = SearchProductService::generateBreadcrumb($filters);

        // dd($breadcrumb);

        return Inertia::render('Search/Search', [
            'filters' => $filters,
            'listDepartments' => CategoryFilterResource::collection($listDepartments),
            'listCategories' => CategoryFilterResource::collection($listCategories),
            'listColors' => ColorAttributeResource::collection($listColors),
            'listSizes' => SizeAttributeResource::collection($listSizes),
            'listBrands' => [], //$listBrands,
            'products' => ProductResource::collection($products),
            'page' => $page,
            'banner' => $banner,
            // 'breadcrumb' => $breadcrumb,
        ]);
    }
}
