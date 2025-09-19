<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('jwt')->group(function () {
        Route::get('me', [AuthController::class, 'me'])->name('me');
        Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');

        // 🔹 Tambah route change password
        Route::post('change-password', [AuthController::class, 'changePassword'])->name('change-password');
    });
});

// 🔹 Resource Product tetap dilindungi jwt
Route::middleware('jwt')->group(function () {
    Route::apiResource('products', ProductController::class);
});
