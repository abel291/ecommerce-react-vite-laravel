<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageResource;
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
			'canLogin' => Route::has('login'),
			'canRegister' => Route::has('register'),
			'laravelVersion' => Application::VERSION,
			'phpVersion' => PHP_VERSION,
			'featured' => $featured,
			'newProducts' => $newProducts,
			'carouselTop' => ImageResource::collection($carousel_top),
			'bannersTop' => ImageResource::collection($banners_top),
			'bannersMedium' => ImageResource::collection($banners_medium),
			'bannersBottom' => ImageResource::collection($banners_bottom),
		]);
	}
}
