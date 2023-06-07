<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
		$combos = Page::factory()->create(['type' => 'combos', 'title' => 'Combos']);
		$assemblies = Page::factory()->create(['type' => 'assemblies', 'title' => 'Ensambles']);
		$contact = Page::factory()->create(['type' => 'contact', 'title' => 'Contáctenos']);
		$search = Page::factory()->create(['type' => 'search', 'title' => 'Busqueda']);
		$blog = Page::factory()->create(['type' => 'blog', 'title' => 'Blog']);

		$images =
			[
				[
					'img' => '/img/home/banner-carousel-1.jpg',
					'alt' => 'banner-1',
					'title' => 'banner-1',
					'type' => 'carousel',
					'sort' => 1,
					'position' => 'top',
					'link' => 'https://www.asus.com/co/laptops/for-creators/vivobook/asus-vivobook-pro-15-oled-m6500-amd-ryzen-5000-series/',
					'imageable_id' => $home->id,
					'imageable_type' => 'App\Models\Page',

				],
				[
					'img' => '/img/home/banner-carousel-2.jpg',
					'alt' => 'banner-2',
					'title' => 'banner-2',
					'type' => 'carousel',
					'sort' => 2,
					'position' => 'top',
					'link' => 'https://co.store.asus.com/90nb0wx1-m004j0-portatil-zenbook-17-3-foled-ux9702-12th-gen-intel-i7-16gb-1tb-ssd-intelr-iris-xe-graphics-17-3-ux9702aa-md007w.html',
					'imageable_id' => $home->id,
					'imageable_type' => 'App\Models\Page',

				],
				[
					'img' => '/img/home/banner-carousel-3.jpg',
					'alt' => 'banner-3',
					'title' => 'banner-3',
					'type' => 'carousel',
					'sort' => 3,
					'position' => 'top',
					'link' => 'https://co.store.asus.com/90nb0xk1-m001s0-portatil-vivobook-15-oled-k6500zc-12th-gen-intel-i5-16gb-512gb-ssd-rtx3050-15-6-k6500zc-ma016w.html',
					'imageable_id' => $home->id,
					'imageable_type' => 'App\Models\Page',

				],
				[
					'img' => '/img/home/banner-carousel-4.jpg',
					'alt' => 'banner-3',
					'title' => 'banner-3',
					'type' => 'carousel',
					'sort' => 4,
					'position' => 'top',
					'link' => 'https://co.store.asus.com/90nr0cg1-m00500-portatil-rog-strix-scar-18-g834jy-18-wqxga-qhd-i9-32gb-2tb-ssd-rtx4090-18-240hz-g834jy-n6036w.html',
					'imageable_id' => $home->id,
					'imageable_type' => 'App\Models\Page',

				],
				///
				[
					'img' => '/img/home/banner-home-9.png',
					'alt' => 'banner-3',
					'title' => 'banner-3',
					'type' => 'banner',
					'position' => 'top',
					'link' => 'https://www.elgato.com/',
					'imageable_id' => $home->id,
					'imageable_type' => 'App\Models\Page',

				],
				[
					'img' => '/img/home/banner-home-10.png',
					'alt' => 'banner-3',
					'title' => 'banner-3',
					'type' => 'banner',
					'position' => 'top',
					'link' => 'https://www.corsair.com/pc-builder/',
					'imageable_id' => $home->id,
					'imageable_type' => 'App\Models\Page',

				],
				///
				[
					'img' => '/img/home/banner-seccion-1.jpg',
					'alt' => 'banner-3',
					'title' => 'banner-3',
					'type' => 'banner',
					'position' => 'middle',
					'link' => 'https://www.coolermaster.com/catalog/power-supplies/gx-series/gx-iii-gold-850/',
					'imageable_id' => $home->id,
					'imageable_type' => 'App\Models\Page',

				],
				[
					'img' => '/img/home/banner-seccion-2.jpg',
					'alt' => 'banner-3',
					'title' => 'banner-3',
					'type' => 'banner',
					'position' => 'below',
					'link' => 'https://co.vsglatam.com/products/helix',
					'imageable_id' => $home->id,
					'imageable_type' => 'App\Models\Page',

				],

				///page - offers
				[
					'img' => '/img/offers/banner-1.jpg',
					'alt' => 'banner-3',
					'title' => 'banner-3',
					'type' => 'banner',
					'position' => 'top',
					'link' => route('offers'),
					'imageable_id' => $offers->id,
					'imageable_type' => 'App\Models\Page',

				],
				///page - combos
				[
					'img' => '/img/combos/banner-1.jpg',
					'alt' => 'banner-3',
					'title' => 'banner-3',
					'type' => 'banner',
					'position' => 'top',
					'link' => route('offers'),
					'imageable_id' => $combos->id,
					'imageable_type' => 'App\Models\Page',

				],

				//page - assemblies
				[
					'img' => '/img/assemblies/banner-1.jpg',
					'alt' => 'banner-3',
					'title' => 'banner-3',
					'type' => 'carousel',
					'sort' => 1,
					'position' => 'top',
					'link' => route('assemblies'),
					'imageable_id' => $assemblies->id,
					'imageable_type' => 'App\Models\Page',

				],
				[
					'img' => '/img/assemblies/banner-2.jpg',
					'alt' => 'banner-3',
					'title' => 'banner-3',
					'type' => 'carousel',
					'sort' => 2,
					'position' => 'top',
					'link' => route('assemblies'),
					'imageable_id' => $assemblies->id,
					'imageable_type' => 'App\Models\Page',

				],
				[
					'img' => '/img/assemblies/banner-3.jpg',
					'alt' => 'banner-3',
					'title' => 'banner-3',
					'type' => 'carousel',
					'sort' => 3,
					'position' => 'top',
					'link' => route('assemblies'),
					'imageable_id' => $assemblies->id,
					'imageable_type' => 'App\Models\Page',

				],

				[
					'img' => '/img/banner-sidebar-search.jpg',
					'alt' => 'banner-3',
					'title' => 'banner-3',
					'type' => 'banner',
					'position' => 'middle',
					'link' => 'https://www.logitechstore.com.ar/Gaming/Volantes',
					'imageable_id' => $search->id,
					'imageable_type' => 'App\Models\Page',

				],
				//
				[
					'img' => '/img/blog/banner_ad.jpg',
					'alt' => 'banner-3',
					'title' => 'banner-3',
					'type' => 'banner',
					'position' => 'middle',
					'link' => 'https://c1.neweggimages.com/WebResource/Themes/Nest/ne_features_pcbuilder.jpg',
					'imageable_id' => $blog->id,
					'imageable_type' => 'App\Models\Page',

				],


			];
		foreach ($images as $key => $image) {
			Image::factory()->create($image);
		}
	}
}
