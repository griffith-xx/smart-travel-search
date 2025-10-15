<?php

use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\DestinationScraperController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('destinations')->group(function () {
    Route::get('/', [DestinationController::class, 'index']);
    Route::post('/', [DestinationController::class, 'store']);

    Route::get('/history/scraper', [DestinationScraperController::class, 'index']);
    Route::post('/history/scraper', [DestinationScraperController::class, 'store']);
});
