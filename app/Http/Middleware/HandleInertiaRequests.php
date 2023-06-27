<?php

namespace App\Http\Middleware;

use App\Models\Brand;
use App\Models\Category;
use App\Services\Settings;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Middleware;
use Tests\Feature\ShoppingCartTest;
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
				'shoppingCart' => function () {
					return Cache::remember('shoppingCart', 3600, function () {
						return auth()->user()->shoppingCart()->count();
					});
				},
			],

			'categories' => function () {
				return Cache::remember('categories', 3600, function () {
					$departments = Category::select('id', 'name', 'slug', 'img', 'category_id')
						->whereActive(true)
						->whereNull('category_id')
						->with('categories')
						->withCount('categories')
						->where('type', '=', 'product')
						->orderBy('categories_count', 'desc')
						->get();

					return $departments;
				});
			},
			'brands' => function () {
				return Cache::remember('brands', 3600, function () {
					return Brand::whereActive(true)->select('id', 'name', 'slug', 'img')->get();
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
