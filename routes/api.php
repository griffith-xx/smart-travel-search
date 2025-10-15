<?php

use App\Http\Controllers\Api\DestinationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('destinations')->group(function () {
    Route::post('/', [DestinationController::class, 'store'])->name('destinations.store');;
});
