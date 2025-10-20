<?php

use App\Http\Controllers\User\CommentLikeController;
use App\Http\Controllers\User\DestinationCommentController;
use App\Http\Controllers\User\DestinationController;
use App\Http\Controllers\User\DestinationLikeController;
use App\Http\Controllers\User\MapController;
use App\Http\Controllers\User\UserPreferenceController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
    Route::get('/destinations/recommended', [DestinationController::class, 'recommended'])->name('destinations.recommended');
    Route::get('/destinations/saved', [DestinationController::class, 'saved'])->name('destinations.saved');
    Route::get('/destinations/{slug}', [DestinationController::class, 'show'])->name('destinations.show');

    Route::get('/map', [MapController::class, 'index'])->name('map.index');

    Route::post('/destinations/{destination}/like', [DestinationLikeController::class, 'toggle'])->name('destinations.like.toggle');

    Route::post('/destinations/{destination}/comments', [DestinationCommentController::class, 'store'])->name('destinations.comments.store');
    Route::put('/comments/{comment}', [DestinationCommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [DestinationCommentController::class, 'destroy'])->name('comments.destroy');

    Route::post('/comments/{comment}/like', [CommentLikeController::class, 'toggle'])->name('comments.like.toggle');

    Route::get('/preferences', [UserPreferenceController::class, 'index'])->name('preferences.index');
    Route::get('/preferences/create', [UserPreferenceController::class, 'create'])->name('preferences.create');
    Route::post('/preferences/store', [UserPreferenceController::class, 'store'])->name('preferences.store');
    Route::get('/preferences/edit', [UserPreferenceController::class, 'edit'])->name('preferences.edit');
    Route::put('/preferences/update', [UserPreferenceController::class, 'update'])->name('preferences.update');
});
