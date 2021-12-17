<?php

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

Route::get('/', 'App\Http\Controllers\IndexController@index')->name('index.index');
Route::get('cart', 'App\Http\Controllers\CartController@index')->name('cart.index');
Route::get('login', 'App\Http\Controllers\LoginController@index')->name('login');
Route::get('products', 'App\Http\Controllers\ProductsController@index')->name('products.index');
Route::get('product/{id}/edit', 'App\Http\Controllers\ProductController@edit')->name('product.edit');
Route::get('product', 'App\Http\Controllers\ProductController@index')->name('product.index');
Route::get('orders', 'App\Http\Controllers\OrdersController@index')->name('orders.index');
Route::get('order', 'App\Http\Controllers\OrderController@index')->name('order.index');
Route::get('order/{id}', 'App\Http\Controllers\OrderController@show')->name('order.show');

Route::post('product', 'App\Http\Controllers\ProductController@store')->name('product.store');
Route::post('/', 'App\Http\Controllers\IndexController@store')->name('index.store');
Route::post('cart', 'App\Http\Controllers\CartController@store')->name('cart.store');
Route::post('login', 'App\Http\Controllers\LoginController@store')->name('login.store');

Route::put('product/{id}', 'App\Http\Controllers\ProductController@update')->name('product.update');
Route::delete('products', 'App\Http\Controllers\ProductsController@destroy')->name('products.destroy');
Route::delete('cart', 'App\Http\Controllers\CartController@destroy')->name('cart.destroy');
