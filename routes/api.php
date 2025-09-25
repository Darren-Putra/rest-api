<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('jwt')->group(function () {
        Route::get('me', [AuthController::class, 'me'])->name('me');
        Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
        Route::post('change-password', [AuthController::class, 'changePassword'])->name('change-password');
    });
});

// ==============================
// 🔹 Produk Umum (SEMUA ROLE)
// ==============================
Route::middleware('jwt')->group(function () {
    Route::apiResource('products', ProductController::class);
});

// ==============================
// 🔹 Seller Product Management
// ==============================
Route::middleware(['jwt', 'role:seller'])->prefix('seller')->group(function () {
    // lihat semua produk milik seller login
    Route::get('products', [ProductController::class, 'sellerProducts']);
    // edit produk milik seller login
    Route::put('products/{id}', [ProductController::class, 'updateSellerProduct']);
    // hapus produk milik seller login
    Route::delete('products/{id}', [ProductController::class, 'deleteSellerProduct']);
});

// ==============================
// 🔹 Admin Product Management + User Management
// ==============================
Route::middleware(['jwt', 'role:admin'])->prefix('admin')->group(function () {
    // produk
    Route::get('products', [ProductController::class, 'allSellerProducts']);
    Route::put('products/{id}', [ProductController::class, 'updateAnyProduct']);
    Route::delete('products/{id}', [ProductController::class, 'deleteAnyProduct']);
    
    // user
    Route::get('users', [UserController::class, 'index']); // lihat semua user
    Route::put('users/{id}/role', [UserController::class, 'updateRole']); // ubah role user
});
