<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ColorResource;
use App\Http\Resources\ImageResource;
use App\Http\Resources\PageResource;

use App\Http\Resources\ProductCardResource;
use App\Http\Resources\ProductResource;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;

use App\Models\Product;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function home()
    {

        $page = Page::with('banners', 'metaTag')->where('type', 'home')->firstOrFail();

        $bestSeller = Product::activeInStock()
            ->variant()
            ->card()
            ->bestSeller()
            ->inRandomOrder()
            ->limit(15)
            ->get();

        $newProducts = Product::activeInStock()
            ->variant()
            ->card()
            ->inRandomOrder()
            ->limit(10)
            ->get();

        // dd($bestSeller[0]);
        $banners = $page->banners->where('active', 1);
        $carousel_top = $banners->where('position', 'top')->where('type', 'carousel')->sortBy('sort');
        $banners_top = $banners->where('position', 'top')->where('type', 'banner');
        $banners_medium = $banners->where('position', 'middle');
        $banners_bottom = $banners->where('position', 'below');

        $categories = Category::active()->where('type', 'product')->where('in_home', 1)->get();
        // $brands = Brand::active()->select('name', 'slug', 'img')->get();

        return Inertia::render('Home/Home', [
            'page' => new PageResource($page),
            'productsBestSeller' => ProductCardResource::collection($bestSeller),
            'newProducts' => ProductCardResource::collection($newProducts),
            'carouselTop' => ImageResource::collection($carousel_top),
            'bannersTop' => ImageResource::collection($banners_top),
            'bannersMedium' => ImageResource::collection($banners_medium),
            'bannersBottom' => ImageResource::collection($banners_bottom),
            'categoriesProductCount' => CategoryResource::collection($categories),
            // 'brands' => $brands,
        ]);
    }

    public function offers()
    {

        $page = Page::with('banners')->where('type', 'offers')->firstOrFail();
        $banners = $page->banners->where('active', 1);
        $banners_top = $banners->where('position', 'top')->where('type', 'banner');
        $offer_products = Product::activeInStock()->card()
            ->inOffer()->orderBy('offer', 'desc')->limit(16)->get();

        $categories = Category::active()
            ->withCount([
                'products' => function ($query) {
                    $query->activeInStock()->inOffer();
                }
            ])
            ->whereHas('products', function ($query) {
                $query->activeInStock()->inOffer();
            })
            ->orderBy('products_count', 'desc')
            ->inRandomOrder()->limit(20)
            ->get();



        return Inertia::render('Offers/Offers', [
            'page' => $page,
            'offerProducts' => ProductCardResource::collection($offer_products),
            'bannersTop' => ImageResource::collection($banners_top),
            //'offerBrands' => $offer_brands,
        ]);
    }

    public function contact()
    {
        $page = Page::where('type', 'contact')->firstOrFail();

        return Inertia::render('Contact/Contact', [
            'page' => $page,
        ]);
    }

    public function product($slug, $ref)
    {

        $product = Product::where('slug', $slug)
            ->where('ref', $ref)
            ->variant()
            ->with('images', 'category', 'department', 'brand', 'specifications.specification_values', 'skus.size')
            ->activeInstock()
            ->withSum('skus', 'stock')
            ->firstOrFail();

        $variants = Product::variant()->select('id', 'name', 'thumb', 'ref', 'slug', 'color_id')->with('color')->where('parent_id', $product->parent_id)->active()
            ->withSum('skus', 'stock')->get()->map(function ($item) {

                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'ref' => $item->ref,
                    'thumb' => $item->thumb,
                    'slug' => $item->slug,
                    'color' => new ColorResource($item->color),
                    'inStock' => boolval($item->skus_sum_stock),
                ];
            });

        // $variants->transform(function ($item, int $key) {
        //     $item->inStock = $item->skus->sum('stock') > 0;
        //     return $item;
        // });

        $related_products = Product::activeInStock()
            ->card()
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->where('department_id', $product->department_id)
            ->inRandomOrder()->limit(12)->get();

        return Inertia::render('Product/Product', [
            'product' => new ProductResource($product),
            'variants' => $variants,
            'relatedProducts' => ProductCardResource::collection($related_products),
        ]);
    }
}
