<?php

use Illuminate\Foundation\Application;
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

Route::get('/', function () {
    return view('index');
});

Route::get('/cart', function () {
    return view('index');
});
Route::get('/login', function () {
    return view('index');
});
Route::get('/products', function () {
    return view('index');
});

Route::get('index', 'App\Http\Controllers\IndexController@show');
Route::get('cartShow', 'App\Http\Controllers\CartController@show');
Route::get('loginShow', 'App\Http\Controllers\LoginController@show');
Route::get('productsShow', 'App\Http\Controllers\ProductsController@show');
Route::get('product/{id}', 'App\Http\Controllers\ProductController@edit');

Route::post('cart', 'App\Http\Controllers\CartController@store');
Route::post('/', 'App\Http\Controllers\IndexController@store');
Route::post('login', 'App\Http\Controllers\LoginController@store');

Route::post('products', 'App\Http\Controllers\ProductsController@delete');

//Route::post('login', 'App\Http\Controllers\LoginController@store');
//Route::get('/smt', 'App\Http\Controllers\IndexController@showProds');
//
//Route::get('cart', 'App\Http\Controllers\CartController@show');
//Route::get('login', 'App\Http\Controllers\LoginController@show');
//Route::get('products', 'App\Http\Controllers\ProductsController@show');
//Route::get('product/{id}', 'App\Http\Controllers\ProductController@edit');
//Route::get('product', 'App\Http\Controllers\ProductController@show');
Route::get('orders', 'App\Http\Controllers\OrdersController@show');
Route::get('order', 'App\Http\Controllers\OrderController@show');
