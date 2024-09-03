<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'index']); // 查詢所有用戶
Route::get('/users/{id}', [UserController::class, 'show']); // 查詢某個用戶
Route::post('/users', [UserController::class, 'store']); // 新增用戶
Route::put('/users/{id}', [UserController::class, 'update']); // 更新用戶
Route::delete('/users/{id}', [UserController::class, 'destroy']); // 刪除用戶
Route::get('/users', [UserController::class, 'getNewUsers']);
Route::get('/test-api', function () {
    return 'API route is working';
});
