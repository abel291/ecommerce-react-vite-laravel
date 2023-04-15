<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
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
	Route::get('/search', 'home')->name('search');
	Route::get('/product/{slug}', 'home')->name('product');
	Route::get('/blog', 'home')->name('blog');
	Route::get('/gift-card', 'home')->name('gift-card');
});

Route::post('/subscribe', function () {
	sleep(3);
	return Redirect::back()->with('success', 'Suscripción completada con exito');
})->name('subscribe');
Route::post('/contact-form', function () {
	sleep(3);
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

require __DIR__ . '/auth.php';
