<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\ProvinceController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginPage'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.store');

    Route::middleware(['auth:admin', 'share.admin'])->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('/provinces', ProvinceController::class);
        Route::resource('/destinations', DestinationController::class);
    });
});
