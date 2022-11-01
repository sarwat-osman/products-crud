<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Auth::routes();

Route::group([
    'middleware' => 'auth',
], function() {	
	Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
	Route::resource('products', ProductController::class);
	Route::post('get-subcategories', [ProductController::class, 'getSubcategories']);
	Route::post('/filter', [ProductController::class, 'filter'])->name('filter');
	Route::post('/search', [ProductController::class, 'search'])->name('search');
	Route::get('/', [ProductController::class, 'index']);
});



