<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Route::middleware('auth')->group(function () {

//     Route::prefix('profile')->name('profile.')->group(function () {

//         Route::controller(ProfileController::class)->group(function () {

//             Route::get('/', 'index')->name('index');

//             Route::get('/account-details', 'accountDetails')->name('account-details');
//             Route::patch('/account-details', 'update')->name('account-details.update');
//             Route::get('/change-password', 'changePassword')->name('password');
//             Route::put('/change-password', 'passwordUpdate')->name('password-update');
//         });

//         Route::controller(ProfileOrderController::class)->group(function () {

//             Route::get('/my-orders', 'orders')->name('orders');
//             Route::get('/order/{code}', 'orderDetails')->name('order');
//             Route::get('/order-pdf/{code}', 'invoicePdf')->name('invoice');
//         });
//     });

//     Route::resource('shopping-cart', ShoppingCartController::class)->only([
//         'index',
//         'store',
//         'update',
//         'destroy',
//     ]);

//     Route::controller(CheckoutController::class)->group(function () {

//         Route::get('/checkout', 'checkout')->name('checkout')->middleware(ProductInSession::class);

//         Route::post('/checkout/add-single-product', 'addSingleProduct')->name('checkout.add-single-product');

//         Route::get('/checkout/add-shopping-cart', 'addShoppingCart')->name('checkout.add-shopping-cart');
//     });

//     Route::controller(DiscountCheckoutController::class)->middleware(ProductInSession::class)->group(function () {
//         Route::post('/checkout/discount', 'applyDiscount')->name('checkout.apply-discount');
//         Route::get('/checkout/delete/discount', 'removeDiscount')->name('checkout.remove-discount');
//     });

//     Route::controller(PaymentCheckoutController::class)->middleware(ProductInSession::class)->group(function () {
//         Route::post('/purchase', 'purchase')->name('purchase');
//     });
// });

require __DIR__ . '/auth.php';
