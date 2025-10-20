<?php

use App\Http\Controllers\Auth\DirectPasswordResetController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Direct Password Reset (Bypass Email Verification)
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [DirectPasswordResetController::class, 'create'])
        ->name('password.request');
    Route::post('/forgot-password/validate', [DirectPasswordResetController::class, 'validateEmail'])
        ->name('password.validate');
    Route::post('/forgot-password/reset', [DirectPasswordResetController::class, 'update'])
        ->name('password.direct.update');
});

require __DIR__.'/user.php';
require __DIR__.'/admin.php';
