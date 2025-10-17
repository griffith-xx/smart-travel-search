<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RecommendationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function __construct(public RecommendationService $recommendationService) {}

    /**
     * Get personalized recommendations for the authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        $limit = $request->integer('limit', 10);
        $limit = min($limit, 50); // Max 50 items

        $recommendations = $this->recommendationService->getRecommendations($user->id, $limit);

        return response()->json([
            'data' => $recommendations,
            'meta' => [
                'total' => $recommendations->count(),
                'limit' => $limit,
            ],
        ]);
    }

    /**
     * Get similar destinations based on a specific destination.
     */
    public function similar(Request $request, int $destinationId): JsonResponse
    {
        $limit = $request->integer('limit', 5);
        $limit = min($limit, 20); // Max 20 items

        try {
            $similarDestinations = $this->recommendationService->getSimilarDestinations($destinationId, $limit);

            return response()->json([
                'data' => $similarDestinations,
                'meta' => [
                    'total' => $similarDestinations->count(),
                    'limit' => $limit,
                    'destination_id' => $destinationId,
                ],
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Destination not found',
            ], 404);
        }
    }

    /**
     * Get popular destinations (no authentication required).
     */
    public function popular(Request $request): JsonResponse
    {
        $limit = $request->integer('limit', 10);
        $limit = min($limit, 50); // Max 50 items

        $popularDestinations = $this->recommendationService->getPopularDestinations($limit);

        return response()->json([
            'data' => $popularDestinations,
            'meta' => [
                'total' => $popularDestinations->count(),
                'limit' => $limit,
            ],
        ]);
    }

    /**
     * Get trending destinations based on recent engagement.
     */
    public function trending(Request $request): JsonResponse
    {
        $limit = $request->integer('limit', 10);
        $limit = min($limit, 50);

        $days = $request->integer('days', 7);
        $days = max(1, min($days, 30)); // Between 1-30 days

        $trendingDestinations = $this->recommendationService->getTrendingDestinations($limit, $days);

        return response()->json([
            'data' => $trendingDestinations,
            'meta' => [
                'total' => $trendingDestinations->count(),
                'limit' => $limit,
                'days' => $days,
            ],
        ]);
    }

    /**
     * Get top rated destinations.
     */
    public function topRated(Request $request): JsonResponse
    {
        $limit = $request->integer('limit', 10);
        $limit = min($limit, 50);

        $minRating = $request->float('min_rating', 4.0);
        $minReviews = $request->integer('min_reviews', 5);

        $topRatedDestinations = $this->recommendationService->getTopRatedDestinations($limit, $minRating, $minReviews);

        return response()->json([
            'data' => $topRatedDestinations,
            'meta' => [
                'total' => $topRatedDestinations->count(),
                'limit' => $limit,
                'min_rating' => $minRating,
                'min_reviews' => $minReviews,
            ],
        ]);
    }

    /**
     * Get most favorited destinations.
     */
    public function mostFavorited(Request $request): JsonResponse
    {
        $limit = $request->integer('limit', 10);
        $limit = min($limit, 50);

        $minFavorites = $request->integer('min_favorites', 10);

        $favoritedDestinations = $this->recommendationService->getMostFavoritedDestinations($limit, $minFavorites);

        return response()->json([
            'data' => $favoritedDestinations,
            'meta' => [
                'total' => $favoritedDestinations->count(),
                'limit' => $limit,
                'min_favorites' => $minFavorites,
            ],
        ]);
    }

    /**
     * Get most viewed destinations.
     */
    public function mostViewed(Request $request): JsonResponse
    {
        $limit = $request->integer('limit', 10);
        $limit = min($limit, 50);

        $minViews = $request->integer('min_views', 100);

        $viewedDestinations = $this->recommendationService->getMostViewedDestinations($limit, $minViews);

        return response()->json([
            'data' => $viewedDestinations,
            'meta' => [
                'total' => $viewedDestinations->count(),
                'limit' => $limit,
                'min_views' => $minViews,
            ],
        ]);
    }

    /**
     * Get featured destinations.
     */
    public function featured(Request $request): JsonResponse
    {
        $limit = $request->integer('limit', 10);
        $limit = min($limit, 50);

        $featuredDestinations = $this->recommendationService->getFeaturedDestinations($limit);

        return response()->json([
            'data' => $featuredDestinations,
            'meta' => [
                'total' => $featuredDestinations->count(),
                'limit' => $limit,
            ],
        ]);
    }

    /**
     * Get recommended destinations (editor's picks).
     */
    public function editorsPicks(Request $request): JsonResponse
    {
        $limit = $request->integer('limit', 10);
        $limit = min($limit, 50);

        $recommendedDestinations = $this->recommendationService->getRecommendedDestinations($limit);

        return response()->json([
            'data' => $recommendedDestinations,
            'meta' => [
                'total' => $recommendedDestinations->count(),
                'limit' => $limit,
            ],
        ]);
    }

    /**
     * Get popular destinations by category.
     */
    public function popularByCategory(Request $request, int $categoryId): JsonResponse
    {
        $limit = $request->integer('limit', 10);
        $limit = min($limit, 50);

        $popularDestinations = $this->recommendationService->getPopularByCategory($categoryId, $limit);

        return response()->json([
            'data' => $popularDestinations,
            'meta' => [
                'total' => $popularDestinations->count(),
                'limit' => $limit,
                'category_id' => $categoryId,
            ],
        ]);
    }

    /**
     * Get popular destinations by province.
     */
    public function popularByProvince(Request $request, int $provinceId): JsonResponse
    {
        $limit = $request->integer('limit', 10);
        $limit = min($limit, 50);

        $popularDestinations = $this->recommendationService->getPopularByProvince($provinceId, $limit);

        return response()->json([
            'data' => $popularDestinations,
            'meta' => [
                'total' => $popularDestinations->count(),
                'limit' => $limit,
                'province_id' => $provinceId,
            ],
        ]);
    }

    /**
     * Get collaborative filtering recommendations (User-Based CF).
     */
    public function collaborative(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        $limit = $request->integer('limit', 10);
        $limit = min($limit, 50);

        $minSimilarUsers = $request->integer('min_similar_users', 3);

        $collaborativeRecommendations = $this->recommendationService->getCollaborativeRecommendations(
            $user->id,
            $limit,
            $minSimilarUsers
        );

        return response()->json([
            'data' => $collaborativeRecommendations,
            'meta' => [
                'total' => $collaborativeRecommendations->count(),
                'limit' => $limit,
                'type' => 'user-based-collaborative-filtering',
            ],
        ]);
    }

    /**
     * Get item-based collaborative filtering recommendations.
     */
    public function itemBased(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        $limit = $request->integer('limit', 10);
        $limit = min($limit, 50);

        $itemBasedRecommendations = $this->recommendationService->getItemBasedRecommendations($user->id, $limit);

        return response()->json([
            'data' => $itemBasedRecommendations,
            'meta' => [
                'total' => $itemBasedRecommendations->count(),
                'limit' => $limit,
                'type' => 'item-based-collaborative-filtering',
            ],
        ]);
    }

    /**
     * Get hybrid recommendations combining multiple approaches.
     */
    public function hybrid(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], 401);
        }

        $limit = $request->integer('limit', 10);
        $limit = min($limit, 50);

        $hybridRecommendations = $this->recommendationService->getHybridRecommendations($user->id, $limit);

        return response()->json([
            'data' => $hybridRecommendations,
            'meta' => [
                'total' => $hybridRecommendations->count(),
                'limit' => $limit,
                'type' => 'hybrid',
            ],
        ]);
    }

    /**
     * Get "Users who liked this also liked" recommendations.
     */
    public function usersAlsoLiked(Request $request, int $destinationId): JsonResponse
    {
        $limit = $request->integer('limit', 10);
        $limit = min($limit, 50);

        $alsoLikedDestinations = $this->recommendationService->getUsersAlsoLiked($destinationId, $limit);

        return response()->json([
            'data' => $alsoLikedDestinations,
            'meta' => [
                'total' => $alsoLikedDestinations->count(),
                'limit' => $limit,
                'destination_id' => $destinationId,
            ],
        ]);
    }
}
