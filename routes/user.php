<?php

use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\UserPreferenceController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    Route::get('/preferences', [UserPreferenceController::class, 'create'])->name('preferences.create');
    Route::post('/preferences', [UserPreferenceController::class, 'store'])->name('preferences.store');
});
