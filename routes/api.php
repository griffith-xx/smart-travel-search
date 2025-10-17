<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\DestinationScraperController;
use App\Http\Controllers\Api\ProvinceController;
use App\Http\Controllers\Api\RecommendationController;
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
    Route::delete('/history/scraper/{id}', [DestinationScraperController::class, 'destroy']);
});

Route::get('/provinces', [ProvinceController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);

// Recommendation Routes
Route::prefix('recommendations')->group(function () {
    // Personalized recommendations (requires auth)
    Route::get('/', [RecommendationController::class, 'index'])->middleware('auth:sanctum');

    // Collaborative filtering (requires auth)
    Route::get('/collaborative', [RecommendationController::class, 'collaborative'])->middleware('auth:sanctum');
    Route::get('/item-based', [RecommendationController::class, 'itemBased'])->middleware('auth:sanctum');
    Route::get('/hybrid', [RecommendationController::class, 'hybrid'])->middleware('auth:sanctum');

    // Popularity-based recommendations (public)
    Route::get('/popular', [RecommendationController::class, 'popular']);
    Route::get('/trending', [RecommendationController::class, 'trending']);
    Route::get('/top-rated', [RecommendationController::class, 'topRated']);
    Route::get('/most-favorited', [RecommendationController::class, 'mostFavorited']);
    Route::get('/most-viewed', [RecommendationController::class, 'mostViewed']);
    Route::get('/featured', [RecommendationController::class, 'featured']);
    Route::get('/editors-picks', [RecommendationController::class, 'editorsPicks']);

    // Content-based recommendations (public)
    Route::get('/similar/{destinationId}', [RecommendationController::class, 'similar']);
    Route::get('/users-also-liked/{destinationId}', [RecommendationController::class, 'usersAlsoLiked']);

    // Filtered by category/province (public)
    Route::get('/category/{categoryId}', [RecommendationController::class, 'popularByCategory']);
    Route::get('/province/{provinceId}', [RecommendationController::class, 'popularByProvince']);
});
