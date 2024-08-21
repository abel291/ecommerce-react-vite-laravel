<?php

namespace App\Http\Middleware;

use App\Models\Brand;
use App\Models\Department;
use App\Services\CartService;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Middleware;

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
        Cache::flush();


        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user() ? [
                    'role' => $request->user()->getRoleNames()->first(),
                    ...$request->user()->only(['name', 'email', 'phone', 'country', 'city', 'address'])
                ] : null,
                'shoppingCartCount' => count(CartService::session())
            ],
            'departments' => function () {
                return Cache::remember('categories', 3600, function () {
                    return Department::select('id', 'name', 'slug', 'img', 'icon')
                        ->active()
                        ->with(['categories' => function ($query) {
                            $query->select('id', 'name', 'slug')->active();
                        }])

                        ->get();
                });
            },
            'brands' => function () {
                return Cache::remember('brands', 3600, function () {
                    return Brand::whereActive(true)->select('id', 'name', 'slug', 'img')->get();
                });
            },
            'flash' => [
                'success' => fn() => $request->session()->get('success'),
                'error' => fn() => $request->session()->get('error'),
                'subscribe' => fn() => $request->session()->get('subscribe'),
            ],
            'settings' => function () {
                return Cache::rememberForever('settings', function () {
                    return SettingService::data();
                });
            },
        ];
    }
}
