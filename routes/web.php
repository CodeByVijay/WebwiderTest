<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\UserHomeController;
use Illuminate\Support\Facades\Route;

//  User Routes
Route::get('/', [AuthController::class, 'userLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('user.postLogin');
Route::get('/logout', [AdminAuthController::class, 'logout'])->name('user.logout');

Route::middleware(['auth:web'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserHomeController::class, 'index'])->name('user.dashboard');
    Route::post('/store-branch', [UserHomeController::class, 'storeUpdateBranch'])->name('user.storeUpdateBranch');
    Route::get('/get-branch/{id}', [UserHomeController::class, 'getBranch'])->name('user.getBranch');
    Route::get('/delete-branch/{id}', [UserHomeController::class, 'deleteBranch'])->name('user.deleteBranch');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.postLogin');
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    });
});
