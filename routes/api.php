<?php

use App\Http\Controllers\Api\CardProductController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\ProductCheckoutController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('auth')->group(function () {
    //register new user
    Route::post('/register', [AuthenticationController::class, 'register']);
    //login user
    Route::post('/login', [AuthenticationController::class, 'login']);
    //using middleware
    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::get('/profile', function (Request $request) {
            return auth()->user();
        });
        Route::post('/logout', [AuthenticationController::class, 'logout']);

        Route::put('/user/profile-store', [ProfileController::class, 'profile_store']);

        Route::put('/user/password-store', [ProfileController::class, 'password_store']);

        Route::get('/user/orders', [ProfileController::class, 'orders']);
        Route::get('/user/order-details/{code}', [ProfileController::class, 'order_details']);
    });
});


Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/product-checkout', [ProductCheckoutController::class, 'product_checkout']);
    Route::get('/product-checkout-cart', [ProductCheckoutController::class, 'product_checkout_cart']);
    Route::resource('card-products', CardProductController::class)->only([
        'index', 'create', 'store', 'destroy'
    ]);
});

Route::get('/search', [SearchController::class, 'search']);
Route::get('/init', [PageController::class, 'init']);
Route::get('/page/home', [PageController::class, 'home']);
Route::get('/page/offers', [PageController::class, 'offers']);
Route::get('/page/assemblies', [PageController::class, 'assemblies']);
Route::get('/page/combos', [PageController::class, 'combos']);

Route::get('/product/{id}/{slug}', [PageController::class, 'product']);


Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});
