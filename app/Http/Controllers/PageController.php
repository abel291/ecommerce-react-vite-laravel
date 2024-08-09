<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageResource;
use App\Http\Resources\ProductResource;
use App\Models\Attribute;
use App\Models\AttributeProduct;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\Specification;
use Inertia\Inertia;

class PageController extends Controller
{
    public function home()
    {
        $page = Page::with('banners')->where('type', 'home')->firstOrFail();

        $bestSeller = Product::selectForCard()->bestSeller()->activeInStock()->limit(15)->get();

        $newProducts = Product::orderBy('id', 'desc')->activeInStock()->selectForCard()->limit(10)->get();

        $banners = $page->banners->where('active', 1);

        $carousel_top = $banners->where('position', 'top')->where('type', 'carousel');
        $banners_top = $banners->where('position', 'top')->where('type', 'banner');
        $banners_medium = $banners->where('position', 'middle');
        $banners_bottom = $banners->where('position', 'below');

        $categories_product_count = Category::withMoreProducts()
            ->limit(12)
            ->get();
        $brands = Brand::where('active', 1)->select('name', 'slug', 'img')->get();
        return Inertia::render('Home/Home', [
            'page' => $page,
            'bestSeller' => ProductResource::collection($bestSeller),
            'newProducts' => ProductResource::collection($newProducts),
            'carouselTop' => ImageResource::collection($carousel_top),
            'bannersTop' => ImageResource::collection($banners_top),
            'bannersMedium' => ImageResource::collection($banners_medium),
            'bannersBottom' => ImageResource::collection($banners_bottom),
            'categoriesProductCount' => $categories_product_count,
            'brands' => $brands,

        ]);
    }

    public function offers()
    {

        $page = Page::with('banners')->where('type', 'offers')->firstOrFail();



        $offer_products = Product::activeInStock()->selectForCard()
            ->inOffer()->orderBy('offer', 'desc')->limit(15)->get();

        $categories = Category::active()
            ->withCount(['products' => function ($query) {
                $query->activeInStock()->inOffer();
            }])
            ->whereHas('products', function ($query) {
                $query->activeInStock()->inOffer();
            })
            ->orderBy('products_count', 'desc')
            ->inRandomOrder()->limit(20)
            ->get();

        $offer_brands = Brand::select('name', 'slug', 'img')->active()
            ->withCount(['products' => function ($query) {
                $query->activeInStock()->inOffer()->orderBy('offer', 'desc');
            }])
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

    public function product($slug)
    {
        $product = Product::where('slug', $slug)
            ->with('attributes.attribute_values', 'images', 'category', 'department', 'stock', 'brand')
            ->with(['specifications' => function ($query) {
                $query->where('active', 1);
            }])
            ->activeInStock()->firstOrFail();

        $product->setRelation('specifications', $product->specifications->groupBy('type'));



        $related_products = Product::activeInStock()
            ->where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->where('department_id', $product->department_id)
            ->inRandomOrder()->limit(12)->get();

        $attributesDefault = [];

        foreach ($product->attributes as $attribute) {
            $attributesDefault[$attribute->name] = $attribute->attribute_values->where('in_stock', 1)->first()->name;
        }

        return Inertia::render('Product/Product', [
            'product' => new ProductResource($product),
            'attributesDefault' => $attributesDefault,
            'relatedProducts' => ProductResource::collection($related_products),
        ]);
    }
}
