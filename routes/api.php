<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

Route::get('/users', [UserController::class, 'index']); // 查詢所有用戶
Route::get('/users/{id}', [UserController::class, 'show']); // 查詢某個用戶
Route::post('/users', [UserController::class, 'store']); // 新增用戶
Route::put('/users/{id}', [UserController::class, 'update']); // 更新用戶
Route::delete('/users/{id}', [UserController::class, 'destroy']); // 刪除用戶
Route::get('/new-users', [UserController::class, 'getNewUsers']); // 連接新用戶至地端資料庫
Route::get('/products', [ProductController::class, 'index']); // 查詢所有商品

Route::get('/test-api', function () {
    return 'API route is working';
});
