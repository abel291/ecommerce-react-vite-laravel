<?php

namespace App\Http\Middleware;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
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
			'categories' => fn () => Category::select('id', 'name', 'slug', 'img')->where('type', '=', 'product')->get(),
			'brands' => fn () => Brand::all('id', 'name', 'slug', 'img'),
			'flash' => [
				'success' => fn () => $request->session()->get('success'),
				'subscribe' => fn () => $request->session()->get('subscribe')
			],
			'ziggy' => function () use ($request) {
				return array_merge((new Ziggy)->toArray(), [
					'location' => $request->url(),
				]);
			},
		]);
	}
}
