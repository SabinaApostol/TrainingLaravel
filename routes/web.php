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

Route::get('/', 'App\Http\Controllers\IndexController@show');
Route::get('cart', 'App\Http\Controllers\CartController@show');
Route::get('login', 'App\Http\Controllers\LoginController@show');
Route::get('products', 'App\Http\Controllers\ProductsController@show');

Route::get('product/{id}', 'App\Http\Controllers\ProductController@edit');
Route::get('product', 'App\Http\Controllers\ProductController@show');
Route::get('orders', 'App\Http\Controllers\OrdersController@show');
Route::get('order', 'App\Http\Controllers\OrderController@show');

Route::post('product', 'App\Http\Controllers\ProductController@add');
Route::post('product/{id}', 'App\Http\Controllers\ProductController@update');

Route::get('order/{id}', 'App\Http\Controllers\OrderController@show');

Route::post('products', 'App\Http\Controllers\ProductsController@store');
Route::post('/', 'App\Http\Controllers\IndexController@store');
Route::post('cart', 'App\Http\Controllers\CartController@store');
Route::post('login', 'App\Http\Controllers\LoginController@store');


