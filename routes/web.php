<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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

Route::get('/', 'App\Http\Controllers\IndexController@index')->name('index.index');
Route::get('cart', 'App\Http\Controllers\CartController@index')->name('cart.index');
Route::get('products', 'App\Http\Controllers\ProductsController@index')->middleware(['auth'])->name('products.index');
Route::get('product/{id}/edit', 'App\Http\Controllers\ProductController@edit')->middleware(['auth'])->name('product.edit');
Route::get('product/create', 'App\Http\Controllers\ProductController@create')->middleware(['auth'])->name('product.index');
Route::get('orders', 'App\Http\Controllers\OrdersController@index')->middleware(['auth'])->name('orders.index');
Route::get('order', 'App\Http\Controllers\OrderController@index')->middleware(['auth'])->name('order.index');
Route::get('order/{id}', 'App\Http\Controllers\OrderController@show')->middleware(['auth'])->name('order.show');

Route::post('product', 'App\Http\Controllers\ProductController@store')->middleware(['auth'])->name('product.store');
Route::post('/', 'App\Http\Controllers\IndexController@store')->name('index.store');
Route::post('cart', 'App\Http\Controllers\CartController@store')->name('cart.store');
Route::post('cartSPA', 'App\Http\Controllers\CartController@store')->name('cart_spa.store');
Route::post('products', 'App\Http\Controllers\ProductsController@destroy')->middleware(['auth'])->name('products.destroy');

Route::put('product/{id}', 'App\Http\Controllers\ProductController@update')->middleware(['auth'])->name('product.update');
Route::post('product/{id}', 'App\Http\Controllers\ProductController@update')->middleware(['auth'])->name('product_spa.update');

Route::delete('products', 'App\Http\Controllers\ProductsController@destroy')->middleware(['auth'])->name('products.destroy');
Route::post('cart_destroy', 'App\Http\Controllers\CartController@destroy')->name('cart.destroy');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

//require __DIR__.'/auth.php';
