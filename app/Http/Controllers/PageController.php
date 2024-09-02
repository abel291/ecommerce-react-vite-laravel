<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ImageResource;
use App\Http\Resources\PageResource;
use App\Http\Resources\PresentationResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\VariantProductResource;
use App\Http\Resources\VariantResource;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;
use App\Models\Presentation;
use App\Models\Product;
use App\Models\Specification;
use App\Models\Variant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function home()
    {

        $page = Page::with('banners')->where('type', 'home')->firstOrFail();

        $bestSeller = Variant::activeInStock()->card()->orderBy('updated_at', 'desc')->limit(15)->get();
        $newProducts = Variant::activeInStock()->card()->orderBy('updated_at', 'desc')->limit(10)->get();
        // dd($bestSeller[0]);
        $banners = $page->banners->where('active', 1);
        $carousel_top = $banners->where('position', 'top')->where('type', 'carousel');
        $banners_top = $banners->where('position', 'top')->where('type', 'banner');
        $banners_medium = $banners->where('position', 'middle');
        $banners_bottom = $banners->where('position', 'below');

        $categories = Category::active()->where('in_home', 1)->get();
        $brands = Brand::active()->select('name', 'slug', 'img')->get();

        return Inertia::render('Home/Home', [
            'page' => new PageResource($page),
            'bestSeller' => VariantProductResource::collection($bestSeller),
            'newProducts' => VariantProductResource::collection($newProducts),
            'carouselTop' => ImageResource::collection($carousel_top),
            'bannersTop' => ImageResource::collection($banners_top),
            'bannersMedium' => ImageResource::collection($banners_medium),
            'bannersBottom' => ImageResource::collection($banners_bottom),
            'categoriesProductCount' => CategoryResource::collection($categories),
            'brands' => $brands,
        ]);
    }

    public function offers()
    {

        $page = Page::with('banners')->where('type', 'offers')->firstOrFail();

        $offer_products = Product::activeInStock()->card()
            ->inOffer()->orderBy('offer', 'desc')->limit(15)->get();

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

        $offer_brands = Brand::select('name', 'slug', 'img')->active()
            ->withCount([
                'products' => function ($query) {
                    $query->activeInStock()->inOffer()->orderBy('offer', 'desc');
                }
            ])
            ->whereHas('products', function ($query) {
                $query->activeInStock()->inOffer();
            })
            ->orderBy('products_count', 'desc')
            ->inRandomOrder()->limit(10)
            ->get();

        return Inertia::render('Offers/Offers', [
            'page' => $page,
            'offerProducts' => $offer_products,
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

    public function product(Request $request, $slug)
    {
        $colorSlug = $request->color;

        $product = Product::where('slug', $slug)
            ->with('images', 'category', 'department', 'brand', 'specifications.specification_values')
            ->withWhereHas('variant', function ($query) use ($colorSlug) {
                $query->active()->with('skus.size', 'images');

                if ($colorSlug) {
                    $query->withWhereHas('color', function ($query) use ($colorSlug) {
                        $query->where('slug', $colorSlug);
                    });
                } else {
                    $query->whereRelation('skus', 'stock', '>', 0);
                }
            })
            ->withWhereHas('variants', function ($query) {
                $query->active()->with('color')->sumStock();
            })
            ->firstOrFail();

        $product->variants->transform(function ($item, int $key) {
            $item->inStock = $item->skus->sum('stock') > 0;
            return $item;
        });

        $related_products = Product::inStock()
            ->card()
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->where('department_id', $product->department_id)
            ->inRandomOrder()->limit(12)->get();


        // $presentations = Presentation::with('color:id,name,hex', 'size:id,name')
        //     ->where('product_id', $product->id)
        //     ->get();

        // $colors = $presentations->groupBy('color_attribute_id')->map(function ($presentationsGroupBy) {
        //     return [
        //         ...$presentationsGroupBy[0]->color->toArray(),
        //         'default' => $presentationsGroupBy->contains('default', 1)
        //     ];
        // })->values()->toArray();

        // $sizes = $presentations->map(function ($presentation) {
        //     return [
        //         'id' => $presentation->size->id,
        //         'name' => $presentation->size->name,
        //         'default' => $presentation->default,
        //         'colorId' => $presentation->color_attribute_id,
        //         'code' => $presentation->code,
        //         'stock' => $presentation->stock,
        //     ];
        // })->values()->toArray();

        // dd($sizes);

        return Inertia::render('Product/Product', [
            'product' => new ProductResource($product),
            // 'colors' => $colors,
            // 'sizes' => $sizes,
            'relatedProducts' => ProductResource::collection($related_products),
        ]);
    }
}
