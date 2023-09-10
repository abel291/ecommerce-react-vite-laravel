<?php

namespace App\Http\Middleware;

use App\Enums\CartEnum;
use App\Http\Resources\UserResource;
use App\Models\Brand;
use App\Models\Department;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use App\Services\CartService;
use Gloudemans\Shoppingcart\Facades\Cart;

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
        // Cache::flush();
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user() ? new UserResource($request->user()) : null,
                'shoppingCartCount' => $request->user() ? CartService::session(CartEnum::SHOPPING_CART->value)->count() : 0,
                //'shoppingCartCount' => 0,
            ],

            'departments' => function () {
                return Cache::remember('categories', 3600, function () {
                    $departments = Department::select('id', 'name', 'slug', 'img')
                        ->active(true)
                        ->with(['categories' => function ($query) {
                            $query->active();
                        }])
                        ->withCount(['categories' => function ($query) {
                            $query->active();
                        }])
                        ->withCount('products')
                        ->orderBy('products_count', 'desc')
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
                'subscribe' => fn () => $request->session()->get('subscribe'),
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
