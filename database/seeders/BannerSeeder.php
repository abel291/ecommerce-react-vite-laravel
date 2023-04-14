<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Image;
use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$home_id = Page::where('type', 'home')->first()->id;
		//dd($home_id);
		$current_date = date('Y-m-d H:i:s');

		Image::insert(
			[
				[
					'img' => '/img/home/banner-home-5.jpg',
					'alt' => 'banner-1',
					'type' => 'carousel',
					'position' => 'top',
					'link' => route('home'),
					'imageable_id' => $home_id,
					'imageable_type' => 'App\Models\Page',
					'created_at' => $current_date,
					'updated_at' => $current_date
				],
				[
					'img' => '/img/home/banner-home-6.jpg',
					'alt' => 'banner-2',
					'type' => 'carousel',
					'position' => 'top',
					'link' => route('home'),
					'imageable_id' => $home_id,
					'imageable_type' => 'App\Models\Page',
					'created_at' => $current_date,
					'updated_at' => $current_date
				],
				[
					'img' => '/img/home/banner-home-7.jpg',
					'alt' => 'banner-3',
					'type' => 'carousel',
					'position' => 'top',
					'link' => route('home'),
					'imageable_id' => $home_id,
					'imageable_type' => 'App\Models\Page',
					'created_at' => $current_date,
					'updated_at' => $current_date
				],
				[
					'img' => '/img/home/banner-home-8.jpg',
					'alt' => 'banner-3',
					'type' => 'carousel',
					'position' => 'top',
					'link' => route('home'),
					'imageable_id' => $home_id,
					'imageable_type' => 'App\Models\Page',
					'created_at' => $current_date,
					'updated_at' => $current_date
				],
				///
				[
					'img' => '/img/home/banner-home-9.png',
					'alt' => 'banner-3',
					'type' => 'banner',
					'position' => 'top',
					'link' => route('home'),
					'imageable_id' => $home_id,
					'imageable_type' => 'App\Models\Page',
					'created_at' => $current_date,
					'updated_at' => $current_date
				],
				[
					'img' => '/img/home/banner-home-10.png',
					'alt' => 'banner-3',
					'type' => 'banner',
					'position' => 'top',
					'link' => route('home'),
					'imageable_id' => $home_id,
					'imageable_type' => 'App\Models\Page',
					'created_at' => $current_date,
					'updated_at' => $current_date
				],
				///
				[
					'img' => '/img/home/banner-seccion-1.jpg',
					'alt' => 'banner-3',
					'type' => 'banner',
					'position' => 'medium',
					'link' => route('home'),
					'imageable_id' => $home_id,
					'imageable_type' => 'App\Models\Page',
					'created_at' => $current_date,
					'updated_at' => $current_date
				],
				[
					'img' => '/img/home/banner-seccion-2.jpg',
					'alt' => 'banner-3',
					'type' => 'banner',
					'position' => 'bottom',
					'link' => route('home'),
					'imageable_id' => $home_id,
					'imageable_type' => 'App\Models\Page',
					'created_at' => $current_date,
					'updated_at' => $current_date
				],
			]
		);
	}
}
