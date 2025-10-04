<?php

use App\Http\Controllers\User\DestinationController;
use App\Http\Controllers\User\UserPreferenceController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/destinations', [DestinationController::class,'index'])->name('destinations.index');

    Route::get('/preferences', [UserPreferenceController::class, 'index'])->name('preferences.index');
    Route::get('/preferences/create', [UserPreferenceController::class, 'create'])->name('preferences.create');
    Route::post('/preferences/store', [UserPreferenceController::class, 'store'])->name('preferences.store');
});
