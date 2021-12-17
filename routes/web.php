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

Route::get('/', 'App\Http\Controllers\IndexController@index')->name('index');
Route::get('cart', 'App\Http\Controllers\CartController@index')->name('cart');
Route::get('login', 'App\Http\Controllers\LoginController@index')->name('login');
Route::get('products', 'App\Http\Controllers\ProductsController@index')->name('products');
Route::get('product/{id}/edit', 'App\Http\Controllers\ProductController@edit')->name('edit_product');
Route::get('product', 'App\Http\Controllers\ProductController@index')->name('product');
Route::get('orders', 'App\Http\Controllers\OrdersController@index')->name('orders');
Route::get('order', 'App\Http\Controllers\OrderController@index')->name('order');
Route::get('order/{id}', 'App\Http\Controllers\OrderController@show')->name('show_order');

Route::post('product', 'App\Http\Controllers\ProductController@store')->name('store_product');
Route::post('/', 'App\Http\Controllers\IndexController@store')->name('add_to_cart');
Route::post('cart', 'App\Http\Controllers\CartController@store')->name('delete_from_cart');
Route::post('login', 'App\Http\Controllers\LoginController@store')->name('store_login');

Route::put('product/{id}', 'App\Http\Controllers\ProductController@update')->name('update_product');
Route::delete('products', 'App\Http\Controllers\ProductsController@destroy')->name('delete_product');
