<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class PageController extends Controller
{
	public function home()
	{
		$featured = Product::where('featured', true)->get()->random(8);
		$newProducts = Product::orderBy('id', 'desc')->limit(8)->get();
		$page = Page::with('banners')->where('type', 'home')->firstOrFail();

		$carousel_top = $page->banners->where('position', 'top')->where('type', 'carousel');
		$banners_top = $page->banners->where('position', 'top')->where('type', 'banner');
		$banners_medium = $page->banners->where('position', 'medium');
		$banners_bottom = $page->banners->where('position', 'bottom');
		//dd($banners_medium);
		return Inertia::render('Home/Home', [
			'page' => $page,
			'featured' => ProductResource::collection($featured),
			'newProducts' => ProductResource::collection($newProducts),
			'carouselTop' => ImageResource::collection($carousel_top),
			'bannersTop' => ImageResource::collection($banners_top),
			'bannersMedium' => ImageResource::collection($banners_medium),
			'bannersBottom' => ImageResource::collection($banners_bottom),
		]);
	}
	public function offers()
	{

		$page = Page::with('banners')->where('type', 'offers')->firstOrFail();
		$banners_top = $page->banners->where('position', 'top')->where('type', 'banner');
		$products = Product::where('offer', '!=', null)->limit(20)->get()->shuffle();
		return Inertia::render('Offers/Offers', [
			'bannersTop' => ImageResource::collection($banners_top),
			'page' => $page,
			'products' => ProductResource::collection($products),
		]);
	}
	public function combos()
	{
		$page = Page::with('banners')->where('type', 'combos')->firstOrFail();
		$banners_top = $page->banners->where('position', 'top')->where('type', 'banner');
		$products = Category::with('products')->where('slug', 'combos')->first()->products->slice(0, 20);

		return Inertia::render('Combos/Combos', [
			'bannersTop' => ImageResource::collection($banners_top),
			'page' => $page,
			'products' => ProductResource::collection($products),
		]);
	}
	public function assemblies()
	{
		$page = Page::with('banners')->where('type', 'assemblies')->firstOrFail();
		$carousel = $page->banners->where('position', 'top')->where('type', 'carousel');
		$products = Category::with('products')->where('slug', 'ensambles')->first()->products->slice(0, 20);

		return Inertia::render('Assemblies/Assemblies', [
			'carousel' => ImageResource::collection($carousel),
			'page' => $page,
			'products' => ProductResource::collection($products),
		]);
	}
	public function contact()
	{
		$page = Page::with('banners')->where('type', 'contact')->firstOrFail();
		$carousel = $page->banners->where('position', 'top')->where('type', 'banner');

		return Inertia::render('Contact/Contact', [
			'banner' => ImageResource::collection($carousel),
			'page' => $page,
		]);
	}

	public function product($slug)
	{

		$product = Product::with('specifications', 'images', 'category.products')->where('slug', $slug)->first();

		$related_products = $product->category->products->random(10);

		return Inertia::render('Product/Product', [
			'product' => new ProductResource($product),
			'relatedProducts' => ProductResource::collection($related_products),
		]);
	}
}
