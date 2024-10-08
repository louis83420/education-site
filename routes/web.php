<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\OrderController;


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

// 認證路由
Auth::routes();

// 首頁路由
Route::get('/', function () {
    return view('welcome');
});

// HomeController 路由
Route::get('/home', [HomeController::class, 'index'])->name('home');

// 產品資源路由
Route::resource('products', ProductController::class);

// 購物車路由
Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// 正確定義 logout 路由
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::patch('cart/update/{product}', [CartController::class, 'update'])->name('cart.update.product');
Route::patch('cart/update', [CartController::class, 'update'])->name('cart.update');

// 外部API登入方式
Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('auth/facebook', [LoginController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('auth/facebook/callback', [LoginController::class, 'handleFacebookCallback']);
Route::get('/test-socialite', function () {
    dd(Socialite::driver('google'));
});
// 產品編輯和更新路由
Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
// 產品結帳
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
// 產品訂單
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
