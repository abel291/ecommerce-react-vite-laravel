<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
