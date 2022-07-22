<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

class PageController extends Controller
{
    public function init()
    {
        //$pages = Page::get()->keyBy('type');

        $categories = Category::get();
        $brands = Brand::get();

        return response()->json([
            'categories' => $categories,
            'brands' => $brands,

        ]);
    }

    public function home()
    {
        $featured = Product::where('featured', true)->get()->random(8);
        $new = Product::orderBy('id', 'desc')->limit(8)->get();
        $banners = [
            'carousel' => [
                [
                    'img' => '/img/home/banner-home-5.jpg',
                    'alt' => 'banner-1',
                ],
                [
                    'img' => '/img/home/banner-home-6.jpg',
                    'alt' => 'banner-2',
                ],
                [
                    'img' => '/img/home/banner-home-7.jpg',
                    'alt' => 'banner-3',
                ],
                [
                    'img' => '/img/home/banner-home-8.jpg',
                    'alt' => 'banner-3',
                ],

            ],
            'left' => [
                'img' => '/img/home/banner-home-9.png',
                'alt' => 'banner-9',
                'path' => 'https://www.corsair.com/p/10WAA9901',
            ],
            'right' => [
                'img' => '/img/home/banner-home-10.png',
                'alt' => 'banner-10',
                'path' => 'https://www.corsair.com/ddr5-memory',
            ],
        ];

        return response()->json([
            'featured' => $featured,
            'new' => $new,
            'banners' => $banners,
        ]);
    }

    public function product($id, $slug)
    {
        $related_products = Product::whereBetween('id', [$id - 5, $id + 5])->limit(5)->get();
        $product = Product::with('specifications', 'images', 'category')->where('id', $id)->where('slug', $slug)->first();

        return response()->json([
            'product' => $product,
            'related_products' => $related_products,
        ]);
    }

    public function offers()
    {
        $products = Product::where('offer', '!=', null)->limit(20)->get()->shuffle();
        $banners = [
            [
                'img' => 'banner-1.jpg',
                'alt' => 'banner-1',
            ],
            [
                'img' => 'banner-2.jpg',
                'alt' => 'banner-2',
            ],
            [
                'img' => 'banner-3.jpg',
                'alt' => 'banner-3',
            ],
        ];

        return response()->json([
            'products' => $products,
            'banners' => $banners,
        ]);
    }

    public function assemblies()
    {
        $products = Category::with('products')->where('slug', 'ensambles')->first()->products->slice(0, 20);
        $banners = [
            [
                'img' => 'banner-1.jpg',
                'alt' => 'banner-1',
            ],
            [
                'img' => 'banner-2.jpg',
                'alt' => 'banner-2',
            ],
            [
                'img' => 'banner-3.jpg',
                'alt' => 'banner-3',
            ],
        ];

        return response()->json([
            'products' => $products,
            'banners' => $banners,
        ]);
    }

    public function combos()
    {
        $products = Category::with('products')->where('slug', 'combos')->first()->products->slice(0, 20);
        $banners = [
            [
                'img' => 'banner-1.jpg',
                'alt' => 'banner-1',
            ],
            [
                'img' => 'banner-2.jpg',
                'alt' => 'banner-2',
            ],
            [
                'img' => 'banner-3.jpg',
                'alt' => 'banner-3',
            ],
        ];

        return response()->json([
            'products' => $products,
            'banners' => $banners,
        ]);
    }
}
