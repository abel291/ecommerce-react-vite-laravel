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
		$home = Page::factory()->create(['type' => 'home', 'title' => 'Home']);
		$offers = Page::factory()->create(['type' => 'offers', 'title' => 'Ofetas']);

		$contact = Page::factory()->create(['type' => 'contact', 'title' => 'Contáctenos']);
		$search = Page::factory()->create(['type' => 'search', 'title' => 'Busqueda']);
		$blog = Page::factory()->create(['type' => 'blog', 'title' => 'Blog']);

		$images =
			[
				[
					'img' => '/storage/img/banners/banner-carousel-1.jpg',
					'alt' => 'banner-1',
					'title' => 'banner-1',
					'type' => 'carousel',
					'sort' => 1,
					'position' => 'top',
					'link' => route('search', ['department' => ['hombre']]),
					'model_id' => $home->id,
					'model_type' => 'App\Models\Page',

				],
				[
					'img' => '/storage/img/banners/banner-carousel-2.jpg',
					'alt' => 'banner-2',
					'title' => 'banner-2',
					'type' => 'carousel',
					'sort' => 2,
					'position' => 'top',
					'link' => route('search', ['department' => ['mujer']]),
					'model_id' => $home->id,
					'model_type' => 'App\Models\Page',

				],
				[
					'img' => '/storage/img/banners/banner-carousel-3.jpg',
					'alt' => 'banner-3',
					'title' => 'banner-3',
					'type' => 'carousel',
					'sort' => 3,
					'position' => 'top',
					'link' => route('search', ['department' => ['nino', 'nina']]),
					'model_id' => $home->id,
					'model_type' => 'App\Models\Page',

				],

				///
				[
					'img' => '/storage/img/banners/banner-home-9.jpg',
					'alt' => 'banner-3',
					'title' => 'banner-3',
					'type' => 'banner',
					'position' => 'top',
					'link' => route('search', ['department' => ['mujer'], 'category' => ['calzado']]),
					'model_id' => $home->id,
					'model_type' => 'App\Models\Page',

				],
				[
					'img' => '/storage/img/banners/banner-home-10.jpg',
					'alt' => 'banner-3',
					'title' => 'banner-3',
					'type' => 'banner',
					'position' => 'top',
					'link' => route('search', ['department' => ['hombre'], 'category' => ['calzado']]),
					'model_id' => $home->id,
					'model_type' => 'App\Models\Page',

				],
				///
				[
					'img' => '/storage/img/banners/banner-section-1.png',
					'alt' => 'banner-3',
					'title' => 'banner-3',
					'type' => 'banner',
					'position' => 'middle',
					'link' => route('search', ['offer' => '10']),
					'model_id' => $home->id,
					'model_type' => 'App\Models\Page',

				],
				[
					'img' => '/storage/img/banners/banner-section-1.png',
					'alt' => 'banner-3',
					'title' => 'banner-3',
					'type' => 'banner',
					'position' => 'below',
					'link' => route('search', ['category' => ['camisetas']]),
					'model_id' => $home->id,
					'model_type' => 'App\Models\Page',

				],

				[
					'img' => '/storage/img/banner-sidebar-search.jpg',
					'alt' => 'banner-3',
					'title' => 'banner-3',
					'type' => 'banner',
					'position' => 'middle',
					'link' => 'https://www.logitechstore.com.ar/Gaming/Volantes',
					'model_id' => $search->id,
					'model_type' => 'App\Models\Page',

				],
				//
				[
					'img' => '/storage/img/blog/banner_ad.jpg',
					'alt' => 'banner-3',
					'title' => 'banner-3',
					'type' => 'banner',
					'position' => 'middle',
					'link' => 'https://c1.neweggimages.com/WebResource/Themes/Nest/ne_features_pcbuilder.jpg',
					'model_id' => $blog->id,
					'model_type' => 'App\Models\Page',

				],

			];
		foreach ($images as $key => $image) {
			Image::factory()->create($image);
		}
	}
}
