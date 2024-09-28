<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use App\Models\MetaTag;
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


        Page::factory()->has(MetaTag::factory()->state([
            'meta_title' => 'Ofetas'
        ]))->create(['type' => 'offers', 'title' => 'Ofetas']);

        Page::factory()->has(MetaTag::factory()->state([
            'meta_title' => 'Contáctenos'
        ]))->create(['type' => 'contact', 'title' => 'Contáctenos']);

        $home = Page::factory()->has(MetaTag::factory()->state([
            'meta_title' => 'Inicio'
        ]))->create([
            'type' => 'home',
            'title' => 'Inicio',
        ]);
        $search = Page::factory()->has(MetaTag::factory()->state([
            'meta_title' => 'Busqueda'
        ]))->create([
            'type' => 'search',
            'title' => 'Busqueda',
        ]);
        $blog = Page::factory()->has(MetaTag::factory()->state([
            'meta_title' => 'Blog'
        ]))->create([
            'type' => 'blog',
            'title' => 'Blog',
        ]);
        $products = Product::select('id', 'slug', 'ref')->variant()->get();
        $categories = Category::select('slug')->get();
        $product = $products->random();
        $images =
            [
                [
                    'img' => '/img/banners/banner-carousel-1.jpg',

                    'type' => 'carousel',
                    'sort' => rand(1, 10),
                    'position' => 'top',
                    'link' => route('product', [$product->slug, $product->ref]),
                    'model_id' => $home->id,
                    'model_type' => 'App\Models\Page',

                ],
                [
                    'img' => '/img/banners/banner-carousel-2.jpg',

                    'type' => 'carousel',
                    'sort' => rand(1, 10),
                    'position' => 'top',
                    'link' => route('search', ['categories' => [$categories->random()->slug]]),
                    'model_id' => $home->id,
                    'model_type' => 'App\Models\Page',

                ],
                [
                    'img' => '/img/banners/banner-carousel-3.jpg',
                    'type' => 'carousel',
                    'sort' => rand(1, 10),
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
