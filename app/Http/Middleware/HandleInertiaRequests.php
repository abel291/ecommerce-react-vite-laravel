<?php

namespace App\Http\Middleware;

use App\Models\Brand;
use App\Models\Category;
use App\Services\Settings;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
	/**
	 * The root template that is loaded on the first page visit.
	 *
	 * @var string
	 */
	protected $rootView = 'app';

	/**
	 * Determine the current asset version.
	 */
	public function version(Request $request): string|null
	{
		return parent::version($request);
	}

	/**
	 * Define the props that are shared by default.
	 *
	 * @return array<string, mixed>
	 */
	public function share(Request $request): array
	{
		return array_merge(parent::share($request), [
			'auth' => [
				'user' => $request->user(),
			],

			'categories' => function () {
				return Cache::rememberForever('categories', function () {
					return Category::select('id', 'name', 'slug', 'img')->where('type', '=', 'product')->get();
				});
			},
			'brands' => function () {
				return Cache::rememberForever('brands', function () {
					return Brand::all('id', 'name', 'slug', 'img');
				});
			},
			'flash' => [
				'success' => fn () => $request->session()->get('success'),
				'error' => fn () => $request->session()->get('error'),
				'subscribe' => fn () => $request->session()->get('subscribe')
			],
			'settings' => function () {
				return Cache::rememberForever('settings', function () {
					return SettingService::data();
				});
			},
			'ziggy' => function () use ($request) {
				return array_merge((new Ziggy)->toArray(), [
					'location' => $request->url(),
				]);
			},
		]);
	}
}
