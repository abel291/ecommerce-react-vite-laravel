<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShoppingCartController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });
Route::controller(PageController::class)->group(function () {

	Route::get('/', 'home')->name('home');
	Route::get('/offers', 'offers')->name('offers');
	Route::get('/combos', 'combos')->name('combos');
	Route::get('/assemblies', 'assemblies')->name('assemblies');
	Route::get('/contact-us', 'contact')->name('contact');
	Route::get('/promotions', 'home')->name('promotions');
	Route::get('/product/{slug}', 'product')->name('product');
	Route::get('/blog', 'home')->name('blog');
	Route::get('/gift-card', 'home')->name('gift-card');
});

Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::post('/subscribe', [NewsletterController::class, 'newsletter'])->name('subscribe');


Route::post('/contact-form', function () {
	sleep(3);
	return Redirect::back()->with('success', 'Formulario  completado con exito');
})->name('contact-form');

Route::get('/dashboard', function () {
	return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

	Route::controller(ProfileController::class)->group(function () {

		Route::get('/profile', 'index')->name('profile');

		Route::get('/profile/my-orders', 'orders')->name('my-orders');

		Route::get('/profile/order/{code}', 'order')->name('order');

		Route::get('/profile/account-details', 'account_details')->name('profile-details');
		Route::patch('/profile/account-details', 'update')->name('profile.update');

		Route::get('/change-password', 'change_password')->name('profile-password');
		Route::put('/change-password', 'password_update')->name('profile-password-update');
	});

	Route::resource('shopping-cart', ShoppingCartController::class)->only([
		'index', 'create', 'store', 'destroy',
	]);

	Route::controller(CheckoutController::class)->group(function () {
		Route::get('/checkout', 'checkout')->name('checkout');
		Route::get('/shopping-cart-checkout', 'shopping_cart_checkout')->name('shopping_cart_checkout');
		Route::post('/pay', 'pay')->name('pay');
	});
});

require __DIR__ . '/auth.php';
