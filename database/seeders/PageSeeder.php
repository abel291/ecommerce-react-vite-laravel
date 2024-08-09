<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Page;
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
        $search = Page::factory()->create(['type' => 'search',  'meta_title' => 'Busqueda', 'title' => 'Busqueda']);
        $blog = Page::factory()->create(['type' => 'blog', 'meta_title' => 'Blog', 'title' => 'Desde el blog']);

        $images =
            [
                [
                    'img' => '/img/banners/banner-carousel-1.jpg',
                    'alt' => 'banner-1',
                    'title' => 'banner-1',
                    'type' => 'carousel',
                    'sort' => 1,
                    'position' => 'top',
                    'link' => route('product', 'portatil-asus-vivobook-m1603qa-r5-5600h-16gb-512ssd-16-fhd-color-quiet-blue33885'),
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
                    'link' => route('search', ['categories' => ['portatiles']]),
                    'model_id' => $home->id,
                    'model_type' => 'App\Models\Page',

                ],
                [
                    'img' => '/img/banners/banner-carousel-3.jpg',
                    'type' => 'carousel',
                    'sort' => 3,
                    'position' => 'top',
                    'link' => route('product', 'portatil-asus-e1504fa-nj474-ryzen-5-7520u-ram-16gb-ssd-512gb-color-negro14523'),
                    'model_id' => $home->id,
                    'model_type' => 'App\Models\Page',

                ],

                ///
                [
                    'img' => '/img/banners/banner-home-9.jpg',
                    'type' => 'banner',
                    'position' => 'top',
                    'link' => route('search', ['categories' => ['portatiles']]),
                    'model_id' => $home->id,
                    'model_type' => 'App\Models\Page',

                ],
                [
                    'img' => '/img/banners/banner-home-10.jpg',
                    'type' => 'banner',
                    'position' => 'top',
                    'link' => route('search', ['categories' => ['placas-base']]),
                    'model_id' => $home->id,
                    'model_type' => 'App\Models\Page',

                ],
                ///
                [
                    'img' => '/img/banners/banner-section-1.jpg',
                    'type' => 'banner',
                    'position' => 'middle',
                    'link' => route('search', ['categories' => ['fuentes-de-alimentacion']]),
                    'model_id' => $home->id,
                    'model_type' => 'App\Models\Page',

                ],
                [
                    'img' => '/img/banners/banner-section-2.jpg',
                    'type' => 'banner',
                    'position' => 'below',
                    'link' => route('product', 'mouse-gamer-cetus-vsg-color-negro3515'),
                    'model_id' => $home->id,
                    'model_type' => 'App\Models\Page',

                ],

                [
                    'img' => '/img/banners/banner-sidebar-search.jpg',
                    'type' => 'banner',
                    'position' => 'middle',
                    'link' => route('product', 'portatil-asus-e1504fa-nj474-ryzen-5-7520u-ram-16gb-ssd-512gb-color-negro14523'),
                    'model_id' => $search->id,
                    'model_type' => 'App\Models\Page',

                ],
                //
                [
                    'img' => '/img/banners/banner-blog.jpg',
                    'type' => 'banner',
                    'position' => 'middle',
                    'link' => route('offers'),
                    'model_id' => $blog->id,
                    'model_type' => 'App\Models\Page',

                ],

            ];
        foreach ($images as $key => $image) {
            Image::factory()->create($image);
        }
    }
}
