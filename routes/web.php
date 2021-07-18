<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayMobController;

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
    return redirect()->route('products');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/store', [App\Http\Controllers\HomeController::class, 'store'])->name('store');

Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products');
Route::delete('/products/{product}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('product.remove');
Route::put('/products/{product}', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update');

Route::get('/addToCart/{product}', [App\Http\Controllers\ProductController::class, 'addToCart'])->name('cart.add');
Route::get('/shopping-cart', [App\Http\Controllers\ProductController::class, 'showCart'])->name('cart.show');
Route::get('/cart.checkout/{amount}', [App\Http\Controllers\ProductController::class, 'checkout'])->name('cart.checkout')->middleware('auth');
Route::get('/cart.checkout1/{amount}', [App\Http\Controllers\ProductController::class, 'checkout1'])->name('cart.checkout1')->middleware('auth');
Route::get('/charge', [App\Http\Controllers\ProductController::class, 'charge'])->name('cart.charge');
Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('order.index');



Route::get('/pay', [PayMobController::class, 'pay'])->name('pay');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');