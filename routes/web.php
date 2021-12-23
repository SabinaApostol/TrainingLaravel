<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('index', [
        'auth_user' => Auth::user()
    ]);
})->name('index');
Route::get('/cart', function () {
    return view('index');
});
Route::get('/login', function () {
    return view('index');
})->middleware(['guest'])->name('login');
Route::get('/products', function () {
    return view('index');
})->middleware(['auth']);
Route::get('/product', function () {
    return view('index');
})->middleware(['auth']);
Route::get('/orders', function () {
    return view('index');
})->middleware(['auth']);
Route::get('/order/{id}', function () {
    return view('index');
})->middleware(['auth']);

Route::get('index', 'App\Http\Controllers\IndexController@index')->name('index.index');
Route::get('cartShow', 'App\Http\Controllers\CartController@show')->name('cart.index');
Route::get('productsShow', 'App\Http\Controllers\ProductsController@show')->middleware(['auth'])->name('products.index');
Route::get('productShow', 'App\Http\Controllers\ProductController@show')->middleware(['auth']);
Route::get('productShow/{id}/edit', 'App\Http\Controllers\ProductController@edit')->middleware(['auth'])->name('product.edit');
Route::get('ordersShow', 'App\Http\Controllers\OrdersController@show')->middleware(['auth'])->name('orders.index');
Route::get('orderShow/{id}', 'App\Http\Controllers\OrderController@show')->middleware(['auth'])->name('order.index');

Route::post('cart', 'App\Http\Controllers\CartController@store')->name('cart.store');
Route::post('/', 'App\Http\Controllers\IndexController@store')->name('index.store');
Route::post('products', 'App\Http\Controllers\ProductsController@delete')->middleware(['auth'])->name('products.store');
Route::post('cart_del', 'App\Http\Controllers\CartController@destroy')->name('cart.destroy')->name('cart.destroy');
Route::post('product', 'App\Http\Controllers\ProductController@store')->middleware(['auth'])->name('product.store');
Route::post('productUpdate/{id}', 'App\Http\Controllers\ProductController@update')->middleware(['auth'])->name('product.update');

Route::post('/loginStore', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
