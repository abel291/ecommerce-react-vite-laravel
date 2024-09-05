<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Page::truncate();
        Image::where('model_type', 'App\Models\Page')->delete();

        Page::factory()->create(['type' => 'offers', 'title' => 'Ofetas']);
        Page::factory()->create(['type' => 'contact', 'title' => 'Contáctenos']);

        $home = Page::factory()->create(['type' => 'home', 'meta_title' => 'Inicio', 'title' => 'Home']);
        $search = Page::factory()->create(['type' => 'search', 'meta_title' => 'Busqueda', 'title' => 'Busqueda']);
        $blog = Page::factory()->create(['type' => 'blog', 'meta_title' => 'Blog', 'title' => 'Desde el blog']);
        $products = Product::select('id', 'slug', 'ref')->get();
        $categories = Category::select('slug')->get();
        $product = $products->random();
        $images =
            [
                [
                    'img' => '/img/banners/banner-carousel-1.jpg',
                    'alt' => 'banner-1',
                    'title' => 'banner-1',
                    'type' => 'carousel',
                    'sort' => 1,
                    'position' => 'top',
                    'link' => route('product', [$product->slug, $product->ref]),
                    'model_id' => $home->id,
                    'model_type' => 'App\Models\Page',

                ],
                [
                    'img' => '/img/banners/banner-carousel-2.jpg',
                    'alt' => 'banner-2',
                    'title' => 'banner-2',
                    'type' => 'carousel',
                    'sort' => 2,
                    'position' => 'top',
                    'link' => route('search', ['categories' => [$categories->random()->slug]]),
                    'model_id' => $home->id,
                    'model_type' => 'App\Models\Page',

                ],
                [
                    'img' => '/img/banners/banner-carousel-3.jpg',
                    'type' => 'carousel',
                    'sort' => 3,
                    'position' => 'top',
                    'link' => route('product', [$product->slug, $product->ref]),
                    'model_id' => $home->id,
                    'model_type' => 'App\Models\Page',

                ],

                [
                    'img' => '/img/banners/banner-home-9.jpg',
                    'type' => 'banner',
                    'position' => 'top',
                    'link' => route('search', ['categories' => [$categories->random()->slug]]),
                    'model_id' => $home->id,
                    'model_type' => 'App\Models\Page',

                ],
                [
                    'img' => '/img/banners/banner-home-10.jpg',
                    'type' => 'banner',
                    'position' => 'top',
                    'link' => route('search', ['categories' => [$categories->random()->slug]]),
                    'model_id' => $home->id,
                    'model_type' => 'App\Models\Page',

                ],
                ///
                [
                    'img' => '/img/banners/banner-section-1.jpg',
                    'type' => 'banner',
                    'position' => 'middle',
                    'link' => route('search', ['categories' => [$categories->random()->slug]]),
                    'model_id' => $home->id,
                    'model_type' => 'App\Models\Page',

                ],
                [
                    'img' => '/img/banners/banner-section-2.jpg',
                    'type' => 'banner',
                    'position' => 'below',
                    'link' => route('product', [$product->slug, $product->ref]),
                    'model_id' => $home->id,
                    'model_type' => 'App\Models\Page',

                ],
                [
                    'img' => '/img/banners/banner-sidebar-search.jpg',
                    'type' => 'banner',
                    'position' => 'middle',
                    'link' => route('product', [$product->slug, $product->ref]),
                    'model_id' => $search->id,
                    'model_type' => 'App\Models\Page',

                ],

                [
                    'img' => '/img/banners/banner-blog.jpg',
                    'type' => 'banner',
                    'position' => 'middle',
                    'link' => route('offers'),
                    'model_id' => $blog->id,
                    'model_type' => 'App\Models\Page',

                ],
            ];
        foreach ($images as $image) {
            Image::factory()->create($image);
        }
    }
}
