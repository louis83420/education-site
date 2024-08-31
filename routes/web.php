<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;


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
Route::patch('cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::patch('cart/update', [CartController::class, 'update'])->name('cart.update');
