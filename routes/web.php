<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\Checkout\CheckoutController;
use App\Http\Controllers\Checkout\DiscountCheckoutController;
use App\Http\Controllers\Checkout\PaymentCheckoutController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Profile\ProfileOrderController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Livewire\Attribute\ListAttribute;
use App\Http\Livewire\Banner\ListBanner;
use App\Http\Livewire\Blog\CreatePost;
use App\Http\Livewire\Blog\ListAuthor;
use App\Http\Livewire\Blog\ListPost;
use App\Http\Livewire\Brand\ListBrand;
use App\Http\Livewire\Category\ListCategory;
use App\Http\Livewire\Dashboard\DashboardPage;
use App\Http\Livewire\DiscountCode\ListDiscountCode;
use App\Http\Livewire\Image\ListImage;
use App\Http\Livewire\Order\ListOrder;
use App\Http\Livewire\Order\ShowOrder;
use App\Http\Livewire\Page\CreatePage;
use App\Http\Livewire\Page\ListPage;
use App\Http\Livewire\Product\CreateProduct;
use App\Http\Livewire\Product\ListProduct;
use App\Http\Livewire\Settings\EditSettings;
use App\Http\Livewire\Specification\ListSpecification;
use App\Http\Livewire\User\ListUser;
use App\Http\Middleware\ProductInSession;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

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
	Route::get('/contact-us', 'contact')->name('contact');
	// Route::get('/promotions', 'home')->name('promotions');
	Route::get('/product/{slug}', 'product')->name('product');
	//Route::get('/gift-card', 'home')->name('gift-card');
});

Route::controller(BlogController::class)->group(function () {
	Route::get('/blog', 'blog')->name('blog');
	Route::get('/post/{slug}', 'post')->name('post');
	Route::get('/author/{slug}', 'post')->name('post.author');
});

Route::get('/department/{department}', [DepartmentController::class, 'department'])->name('department');
Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::post('/subscribe', [NewsletterController::class, 'newsletter'])->name('subscribe');

Route::post('/contact-form', function () {

	return Redirect::back()->with('success', 'Formulario  completado con exito');
})->name('contact-form');

Route::middleware('auth')->group(function () {

	Route::prefix('profile')->name('profile.')->group(function () {

		Route::controller(ProfileController::class)->group(function () {

			Route::get('/', 'index')->name('index');

			Route::get('/account-details', 'accountDetails')->name('account-details');
			Route::patch('/account-details', 'update')->name('account-details.update');
			Route::get('/change-password', 'changePassword')->name('password');
			Route::put('/change-password', 'passwordUpdate')->name('password-update');
		});

		Route::controller(ProfileOrderController::class)->group(function () {

			Route::get('/my-orders', 'orders')->name('orders');
			Route::get('/order/{code}', 'orderDetails')->name('order');
			Route::get('/order-pdf/{code}', 'invoicePdf')->name('invoice');
		});
	});

	Route::resource('shopping-cart', ShoppingCartController::class)->only([
		'index', 'store', 'update', 'destroy',
	]);

	Route::controller(CheckoutController::class)->group(function () {

		Route::get('/checkout', 'checkout')->name('checkout')->middleware(ProductInSession::class);

		Route::post('/checkout/add-single-product', 'addSingleProduct')->name('checkout.add-single-product');

		Route::get('/checkout/add-shopping-cart', 'addShoppingCart')->name('checkout.add-shopping-cart');
	});

	Route::controller(DiscountCheckoutController::class)->middleware(ProductInSession::class)->group(function () {
		Route::post('/checkout/discount', 'applyDiscount')->name('checkout.apply-discount');
		Route::get('/checkout/delete/discount', 'removeDiscount')->name('checkout.remove-discount');
	});

	Route::controller(PaymentCheckoutController::class)->middleware(ProductInSession::class)->group(function () {
		Route::post('/purchase', 'purchase')->name('purchase');
	});

	Route::prefix('dashboard')->name('dashboard.')->middleware(['role:admin'])->group(function () {

		Route::get('/', DashboardPage::class)->name('home');
		Route::get('/users', ListUser::class)->name('users');
		Route::get('/products', ListProduct::class)->name('products');
		Route::get('/banners', ListBanner::class)->name('banners');

		Route::get('/product/create', [CreateProduct::class, '__invoke'])->name('products-create');
		Route::get('/product/{id}/edit', [CreateProduct::class, '__invoke'])->name('products-edit');
		Route::get('/product/{id}/specification', [ListSpecification::class, '__invoke'])->name('products-specifications');

		Route::get('/product/{id}/attributes', [ListAttribute::class, '__invoke'])->name('product-attributes');

		Route::get('/attribute/create', [EditAttribute::class, '__invoke'])->name('attribute-create');
		Route::get('/attribute/{id}/edit', [EditAttribute::class, '__invoke'])->name('attribute-edit');

		Route::get('/posts', ListPost::class)->name('posts');
		Route::get('/post/create', [CreatePost::class, '__invoke'])->name('posts-create');
		Route::get('/post/{id}/edit', [CreatePost::class, '__invoke'])->name('posts-edit');

		Route::get('/pages', ListPage::class)->name('pages');
		Route::get('/page/create', [CreatePage::class, '__invoke'])->name('pages-create');
		Route::get('/page/{id}/edit', [CreatePage::class, '__invoke'])->name('pages-edit');

		Route::get('/orders', ListOrder::class)->name('orders');
		Route::get('/order/{id}/show', [ShowOrder::class, '__invoke'])->name('orders-show');

		Route::get('/discount-codes', ListDiscountCode::class)->name('discount-codes');

		Route::get('/categories', ListCategory::class)->name('categories');
		Route::get('/brands', ListBrand::class)->name('brands');
		Route::get('/authors', ListAuthor::class)->name('authors');
		Route::get('/{name}/{id}/images', [ListImage::class, '__invoke'])->name('images');

		Route::get('/settings', EditSettings::class)->name('settings');
	});
});

require __DIR__ . '/auth.php';
