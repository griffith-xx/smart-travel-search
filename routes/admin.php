<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\ProvinceController;
use App\Http\Controllers\Admin\DestinationPreferenceController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginPage'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.store');

    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('/provinces', ProvinceController::class);
        Route::resource('/categories', CategoryController::class);

        Route::resource('/destinations', DestinationController::class);
        Route::post('destinations/{destination}/toggle-active', [DestinationController::class, 'toggleActive'])
            ->name('destinations.toggle-active');

        Route::post('destinations/{destination}/toggle-featured', [DestinationController::class, 'toggleFeatured'])
            ->name('destinations.toggle-featured');

        Route::get('destinations/preferences/{destination}', [DestinationPreferenceController::class, 'edit'])
            ->name('destinations.preferences.edit');

        Route::patch('destinations/preferences/{destination}', [DestinationPreferenceController::class, 'update'])
            ->name('destinations.preferences.update');

        Route::resource('/users', UserController::class);
    });
});
