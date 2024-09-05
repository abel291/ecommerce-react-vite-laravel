<?php

namespace App\Http\Controllers;


use App\Http\Resources\ColorAttributeResource;
use App\Http\Resources\ColorResource;
use App\Http\Resources\ProductCardResource;
use App\Http\Resources\ProductResource;

use App\Http\Resources\Search\CategoryFilterResource;

use App\Http\Resources\SizeResource;
use App\Models\Category;
use App\Models\Color;
use App\Models\Department;
use App\Models\Page;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SearchController extends Controller
{
    public function search(Request $request)
    {

        $page = Page::with('banners')->where('type', 'search')->firstOrFail();

        $banner = $page->banners->where('position', 'middle')->where('type', 'banner');

        $filters = [
            'q' => $request->input('q', null),
            'departments' => $request->input('departments', []),
            'categories' => $request->input('categories', []),
            'colors' => $request->input('colors', []),
            'sizes' => $request->input('sizes', []),
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

        $listColors = Color::whereHas(
            'products',
            function ($query) use ($filters) {
                $query->withFilters([
                    ...$filters,
                    'colors' => []
                ]);
            }
        )->orderBy('slug')->get();

        $listSizes = Size::select('sizes.id', 'slug', 'name')->whereHas(
            'products',
            function ($query) use ($filters) {
                $query->withFilters([
                    ...$filters,
                    'sizes' => []
                ]);
            }
        )->orderBy('slug')->get();

        // $products = Product::card()->withFilters($filters)->paginate(24)->withQueryString();

        $products = Product::variant()->card()->withFilters($filters)->paginate(24)->withQueryString();

        // dd($products);

        // when($filters['colors'], function (Builder $query) use ($filters) {
        //     $query->whereIn('color_id', $filters['colors']);
        // })
        //     // ->when($filters['sizes'], function (Builder $query) use ($filters) {
        //     //     $query->whereHas('sizes', function ($query) {
        //     //         $query->whereIn('id')->where('pivot.stock', '>', 0);
        //     //     });
        //     // })
        //     ->withWhereHas('product', function ($query) use ($filters) {
        //         $query->withFilters($filters);
        //     })->paginate(24)->withQueryString();

        // $breadcrumb = SearchProductService::generateBreadcrumb($filters);

        // dd($breadcrumb);

        return Inertia::render('Search/Search', [
            'filters' => $filters,
            'listDepartments' => CategoryFilterResource::collection($listDepartments),
            'listCategories' => CategoryFilterResource::collection($listCategories),
            'listColors' => ColorResource::collection($listColors),
            'listSizes' => SizeResource::collection($listSizes),
            'listBrands' => [], //$listBrands,
            'products' => ProductCardResource::collection($products),
            'page' => $page,
            'banner' => $banner,
            // 'breadcrumb' => $breadcrumb,
        ]);
    }
}
