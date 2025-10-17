<?php

namespace App\Services;

use App\Models\Destination;
use App\Models\DestinationLike;
use App\Models\UserPreference;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RecommendationService
{
    /**
     * Get personalized destination recommendations based on user preferences.
     */
    public function getRecommendations(int $userId, int $limit = 10): Collection
    {
        $userPreference = UserPreference::where('user_id', $userId)->first();

        if (! $userPreference) {
            return $this->getPopularDestinations($limit);
        }

        $destinations = Destination::with(['preference', 'province', 'category'])
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->get();

        $scoredDestinations = $destinations->map(function ($destination) use ($userPreference) {
            $score = $this->calculateSimilarityScore($userPreference, $destination);
            $destination->similarity_score = $score;

            return $destination;
        });

        return $scoredDestinations
            ->sortByDesc('similarity_score')
            ->take($limit)
            ->values();
    }

    /**
     * Calculate similarity score between user preferences and destination.
     */
    protected function calculateSimilarityScore(UserPreference $userPreference, Destination $destination): float
    {
        if (! $destination->preference) {
            return 0.0;
        }

        $score = 0.0;
        $maxScore = 0.0;

        // Weight configuration
        $weights = [
            'wellness_goals' => 0.25,
            'activities' => 0.25,
            'environments' => 0.20,
            'keywords' => 0.15,
            'duration_intensity' => 0.075,
            'budget_accommodation' => 0.075,
        ];

        // 1. Wellness Goals Match (25%)
        $wellnessScore = $this->calculateArraySimilarity(
            $userPreference->wellness_goals ?? [],
            $destination->preference->wellness_goals ?? []
        );
        $score += $wellnessScore * $weights['wellness_goals'];
        $maxScore += $weights['wellness_goals'];

        // 2. Activities Match (25%)
        $activitiesScore = $this->calculateArraySimilarity(
            $userPreference->activities ?? [],
            $destination->preference->activities ?? []
        );
        $score += $activitiesScore * $weights['activities'];
        $maxScore += $weights['activities'];

        // 3. Environments Match (20%)
        $environmentsScore = $this->calculateArraySimilarity(
            $userPreference->environments ?? [],
            $destination->preference->environments ?? []
        );
        $score += $environmentsScore * $weights['environments'];
        $maxScore += $weights['environments'];

        // 4. Keywords Match (15%)
        $keywordsScore = $this->calculateArraySimilarity(
            $userPreference->keywords ?? [],
            $destination->preference->keywords ?? []
        );
        $score += $keywordsScore * $weights['keywords'];
        $maxScore += $weights['keywords'];

        // 5. Duration/Intensity Match (7.5%)
        if ($userPreference->duration_intensity_id && $destination->preference->duration_intensity_id) {
            if ($userPreference->duration_intensity_id === $destination->preference->duration_intensity_id) {
                $score += $weights['duration_intensity'];
            }
            $maxScore += $weights['duration_intensity'];
        }

        // 6. Budget/Accommodation Match (7.5%)
        if ($userPreference->budget_accommodation_id && $destination->preference->budget_accommodation_id) {
            if ($userPreference->budget_accommodation_id === $destination->preference->budget_accommodation_id) {
                $score += $weights['budget_accommodation'];
            }
            $maxScore += $weights['budget_accommodation'];
        }

        // Normalize score to 0-100
        return $maxScore > 0 ? ($score / $maxScore) * 100 : 0.0;
    }

    /**
     * Calculate Jaccard similarity between two arrays.
     */
    protected function calculateArraySimilarity(array $userArray, array $destArray): float
    {
        if (empty($userArray) || empty($destArray)) {
            return 0.0;
        }

        $intersection = count(array_intersect($userArray, $destArray));
        $union = count(array_unique(array_merge($userArray, $destArray)));

        return $union > 0 ? $intersection / $union : 0.0;
    }

    /**
     * Get popular destinations as fallback.
     */
    public function getPopularDestinations(int $limit = 10): Collection
    {
        return Destination::with(['preference', 'province', 'category'])
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->orderByDesc('average_rating')
            ->orderByDesc('favorite_count')
            ->orderByDesc('view_count')
            ->limit($limit)
            ->get();
    }

    /**
     * Get trending destinations based on recent engagement.
     */
    public function getTrendingDestinations(int $limit = 10, int $days = 7): Collection
    {
        $destinations = Destination::with(['preference', 'province', 'category'])
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->get();

        $scoredDestinations = $destinations->map(function ($destination) use ($days) {
            $trendScore = $this->calculateTrendScore($destination, $days);
            $destination->trend_score = $trendScore;

            return $destination;
        });

        return $scoredDestinations
            ->sortByDesc('trend_score')
            ->take($limit)
            ->values();
    }

    /**
     * Get top rated destinations.
     */
    public function getTopRatedDestinations(int $limit = 10, float $minRating = 4.0, int $minReviews = 5): Collection
    {
        return Destination::with(['preference', 'province', 'category'])
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('average_rating', '>=', $minRating)
            ->where('total_reviews', '>=', $minReviews)
            ->orderByDesc('average_rating')
            ->orderByDesc('total_reviews')
            ->limit($limit)
            ->get();
    }

    /**
     * Get most favorited destinations.
     */
    public function getMostFavoritedDestinations(int $limit = 10, int $minFavorites = 10): Collection
    {
        return Destination::with(['preference', 'province', 'category'])
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('favorite_count', '>=', $minFavorites)
            ->orderByDesc('favorite_count')
            ->orderByDesc('average_rating')
            ->limit($limit)
            ->get();
    }

    /**
     * Get most viewed destinations.
     */
    public function getMostViewedDestinations(int $limit = 10, int $minViews = 100): Collection
    {
        return Destination::with(['preference', 'province', 'category'])
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('view_count', '>=', $minViews)
            ->orderByDesc('view_count')
            ->orderByDesc('average_rating')
            ->limit($limit)
            ->get();
    }

    /**
     * Get featured destinations.
     */
    public function getFeaturedDestinations(int $limit = 10): Collection
    {
        return Destination::with(['preference', 'province', 'category'])
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('is_featured', true)
            ->orderByDesc('sort_order')
            ->orderByDesc('average_rating')
            ->limit($limit)
            ->get();
    }

    /**
     * Get recommended destinations (editor's picks).
     */
    public function getRecommendedDestinations(int $limit = 10): Collection
    {
        return Destination::with(['preference', 'province', 'category'])
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('is_recommended', true)
            ->orderByDesc('sort_order')
            ->orderByDesc('average_rating')
            ->limit($limit)
            ->get();
    }

    /**
     * Get destinations by category sorted by popularity.
     */
    public function getPopularByCategory(int $categoryId, int $limit = 10): Collection
    {
        return Destination::with(['preference', 'province', 'category'])
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('category_id', $categoryId)
            ->orderByDesc('average_rating')
            ->orderByDesc('favorite_count')
            ->orderByDesc('view_count')
            ->limit($limit)
            ->get();
    }

    /**
     * Get destinations by province sorted by popularity.
     */
    public function getPopularByProvince(int $provinceId, int $limit = 10): Collection
    {
        return Destination::with(['preference', 'province', 'category'])
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('province_id', $provinceId)
            ->orderByDesc('average_rating')
            ->orderByDesc('favorite_count')
            ->orderByDesc('view_count')
            ->limit($limit)
            ->get();
    }

    /**
     * Calculate trend score based on recent engagement.
     */
    protected function calculateTrendScore(Destination $destination, int $days): float
    {
        // Weights for different metrics
        $weights = [
            'rating' => 0.30,
            'favorites' => 0.30,
            'views' => 0.25,
            'reviews' => 0.15,
        ];

        // Normalize each metric (0-100 scale)
        $ratingScore = ($destination->average_rating ?? 0) * 20; // 5-star scale to 100
        $favoritesScore = min(($destination->favorite_count ?? 0) / 10, 100); // Cap at 100
        $viewsScore = min(($destination->view_count ?? 0) / 100, 100); // Cap at 100
        $reviewsScore = min(($destination->total_reviews ?? 0) * 5, 100); // Cap at 100

        // Calculate weighted score
        $score = ($ratingScore * $weights['rating']) +
            ($favoritesScore * $weights['favorites']) +
            ($viewsScore * $weights['views']) +
            ($reviewsScore * $weights['reviews']);

        // Boost if recently published
        if ($destination->published_at) {
            $daysSincePublished = now()->diffInDays($destination->published_at);
            if ($daysSincePublished <= $days) {
                $recencyBoost = 1 + ((($days - $daysSincePublished) / $days) * 0.5); // Up to 50% boost
                $score *= $recencyBoost;
            }
        }

        return $score;
    }

    /**
     * Get similar destinations based on a specific destination.
     */
    public function getSimilarDestinations(int $destinationId, int $limit = 5): Collection
    {
        $destination = Destination::with('preference')->findOrFail($destinationId);

        if (! $destination->preference) {
            return $this->getPopularDestinations($limit);
        }

        $destinations = Destination::with(['preference', 'province', 'category'])
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('id', '!=', $destinationId)
            ->get();

        $scoredDestinations = $destinations->map(function ($otherDestination) use ($destination) {
            $score = $this->calculateDestinationSimilarity($destination, $otherDestination);
            $otherDestination->similarity_score = $score;

            return $otherDestination;
        });

        return $scoredDestinations
            ->sortByDesc('similarity_score')
            ->take($limit)
            ->values();
    }

    /**
     * Calculate similarity between two destinations.
     */
    protected function calculateDestinationSimilarity(Destination $destination1, Destination $destination2): float
    {
        if (! $destination1->preference || ! $destination2->preference) {
            return 0.0;
        }

        $score = 0.0;
        $weights = [
            'wellness_goals' => 0.25,
            'activities' => 0.25,
            'environments' => 0.20,
            'keywords' => 0.15,
            'category' => 0.075,
            'province' => 0.075,
        ];

        // Wellness Goals
        $score += $this->calculateArraySimilarity(
            $destination1->preference->wellness_goals ?? [],
            $destination2->preference->wellness_goals ?? []
        ) * $weights['wellness_goals'];

        // Activities
        $score += $this->calculateArraySimilarity(
            $destination1->preference->activities ?? [],
            $destination2->preference->activities ?? []
        ) * $weights['activities'];

        // Environments
        $score += $this->calculateArraySimilarity(
            $destination1->preference->environments ?? [],
            $destination2->preference->environments ?? []
        ) * $weights['environments'];

        // Keywords
        $score += $this->calculateArraySimilarity(
            $destination1->preference->keywords ?? [],
            $destination2->preference->keywords ?? []
        ) * $weights['keywords'];

        // Same Category
        if ($destination1->category_id === $destination2->category_id) {
            $score += $weights['category'];
        }

        // Same Province
        if ($destination1->province_id === $destination2->province_id) {
            $score += $weights['province'];
        }

        return $score * 100;
    }

    /**
     * Get collaborative filtering recommendations based on user likes (User-Based CF).
     */
    public function getCollaborativeRecommendations(int $userId, int $limit = 10, int $minSimilarUsers = 3): Collection
    {
        // Get destinations the user has liked
        $userLikes = DestinationLike::where('user_id', $userId)
            ->pluck('destination_id')
            ->toArray();

        if (empty($userLikes)) {
            return $this->getPopularDestinations($limit);
        }

        // Find similar users (users who liked the same destinations)
        $similarUsers = $this->findSimilarUsers($userId, $userLikes, $minSimilarUsers);

        if ($similarUsers->isEmpty()) {
            return $this->getPopularDestinations($limit);
        }

        // Get destinations liked by similar users (but not by current user)
        $recommendedDestinations = DestinationLike::whereIn('user_id', $similarUsers->pluck('user_id'))
            ->whereNotIn('destination_id', $userLikes)
            ->select('destination_id', DB::raw('COUNT(*) as like_count'))
            ->groupBy('destination_id')
            ->orderByDesc('like_count')
            ->limit($limit * 2) // Get more to filter later
            ->pluck('destination_id');

        // Load full destination data
        $destinations = Destination::with(['preference', 'province', 'category'])
            ->whereIn('id', $recommendedDestinations)
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->get();

        // Calculate collaborative score
        $scoredDestinations = $destinations->map(function ($destination) use ($similarUsers, $userLikes) {
            $score = $this->calculateCollaborativeScore($destination, $similarUsers, $userLikes);
            $destination->collaborative_score = $score;

            return $destination;
        });

        return $scoredDestinations
            ->sortByDesc('collaborative_score')
            ->take($limit)
            ->values();
    }

    /**
     * Find similar users based on likes.
     */
    protected function findSimilarUsers(int $userId, array $userLikes, int $minSimilarUsers): Collection
    {
        // Find users who liked at least one of the same destinations
        $similarUsers = DestinationLike::whereIn('destination_id', $userLikes)
            ->where('user_id', '!=', $userId)
            ->select('user_id', DB::raw('COUNT(DISTINCT destination_id) as common_likes'))
            ->groupBy('user_id')
            ->having('common_likes', '>=', 1)
            ->orderByDesc('common_likes')
            ->limit(50) // Limit to top 50 similar users
            ->get();

        // Calculate Jaccard similarity for each similar user
        $scoredUsers = $similarUsers->map(function ($user) use ($userId) {
            $otherUserLikes = DestinationLike::where('user_id', $user->user_id)
                ->pluck('destination_id')
                ->toArray();

            $currentUserLikes = DestinationLike::where('user_id', $userId)
                ->pluck('destination_id')
                ->toArray();

            $similarity = $this->calculateJaccardSimilarity($currentUserLikes, $otherUserLikes);
            $user->similarity_score = $similarity;

            return $user;
        });

        return $scoredUsers
            ->where('similarity_score', '>', 0)
            ->sortByDesc('similarity_score')
            ->take($minSimilarUsers * 2) // Get top similar users
            ->values();
    }

    /**
     * Calculate collaborative filtering score.
     */
    protected function calculateCollaborativeScore(Destination $destination, Collection $similarUsers, array $userLikes): float
    {
        // Count how many similar users liked this destination
        $likingUsers = DestinationLike::where('destination_id', $destination->id)
            ->whereIn('user_id', $similarUsers->pluck('user_id'))
            ->count();

        if ($likingUsers === 0) {
            return 0.0;
        }

        // Base score from number of similar users who liked it
        $baseScore = ($likingUsers / $similarUsers->count()) * 70; // Up to 70 points

        // Bonus from destination popularity
        $popularityScore = min(($destination->average_rating ?? 0) * 4, 20); // Up to 20 points

        // Bonus from engagement
        $engagementScore = min(($destination->favorite_count ?? 0) / 10, 10); // Up to 10 points

        return $baseScore + $popularityScore + $engagementScore;
    }

    /**
     * Calculate Jaccard similarity between two arrays.
     */
    protected function calculateJaccardSimilarity(array $array1, array $array2): float
    {
        if (empty($array1) || empty($array2)) {
            return 0.0;
        }

        $intersection = count(array_intersect($array1, $array2));
        $union = count(array_unique(array_merge($array1, $array2)));

        return $union > 0 ? $intersection / $union : 0.0;
    }

    /**
     * Get item-based collaborative recommendations (destinations similar to liked ones).
     */
    public function getItemBasedRecommendations(int $userId, int $limit = 10): Collection
    {
        // Get destinations the user has liked
        $userLikes = DestinationLike::where('user_id', $userId)
            ->pluck('destination_id')
            ->toArray();

        if (empty($userLikes)) {
            return $this->getPopularDestinations($limit);
        }

        // Find destinations that users who liked the same items also liked
        $relatedDestinations = DestinationLike::whereIn('user_id', function ($query) use ($userLikes) {
            $query->select('user_id')
                ->from('destination_likes')
                ->whereIn('destination_id', $userLikes)
                ->groupBy('user_id');
        })
            ->whereNotIn('destination_id', $userLikes)
            ->select('destination_id', DB::raw('COUNT(*) as co_occurrence_count'))
            ->groupBy('destination_id')
            ->orderByDesc('co_occurrence_count')
            ->limit($limit * 2)
            ->pluck('destination_id');

        // Load full destination data
        $destinations = Destination::with(['preference', 'province', 'category'])
            ->whereIn('id', $relatedDestinations)
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->get();

        // Calculate item-based score
        $scoredDestinations = $destinations->map(function ($destination) use ($userLikes) {
            $score = $this->calculateItemBasedScore($destination, $userLikes);
            $destination->item_score = $score;

            return $destination;
        });

        return $scoredDestinations
            ->sortByDesc('item_score')
            ->take($limit)
            ->values();
    }

    /**
     * Calculate item-based collaborative filtering score.
     */
    protected function calculateItemBasedScore(Destination $destination, array $userLikes): float
    {
        // Count co-occurrences with user's liked destinations
        $coOccurrences = DestinationLike::where('destination_id', $destination->id)
            ->whereIn('user_id', function ($query) use ($userLikes) {
                $query->select('user_id')
                    ->from('destination_likes')
                    ->whereIn('destination_id', $userLikes);
            })
            ->count();

        // Base score from co-occurrences
        $baseScore = min($coOccurrences * 15, 70); // Up to 70 points

        // Add popularity score
        $popularityScore = min(($destination->average_rating ?? 0) * 4, 20); // Up to 20 points

        // Add engagement score
        $engagementScore = min(($destination->favorite_count ?? 0) / 10, 10); // Up to 10 points

        return $baseScore + $popularityScore + $engagementScore;
    }

    /**
     * Get hybrid recommendations combining multiple approaches.
     */
    public function getHybridRecommendations(int $userId, int $limit = 10): Collection
    {
        $recommendations = collect();

        // Get content-based recommendations
        $contentBased = $this->getRecommendations($userId, $limit);
        $contentBased = $contentBased->map(function ($dest) {
            $dest->recommendation_type = 'content-based';

            return $dest;
        });

        // Get collaborative recommendations if user has likes
        $userLikesCount = DestinationLike::where('user_id', $userId)->count();
        if ($userLikesCount > 0) {
            $collaborative = $this->getCollaborativeRecommendations($userId, $limit);
            $collaborative = $collaborative->map(function ($dest) {
                $dest->recommendation_type = 'collaborative';

                return $dest;
            });

            // Merge and deduplicate
            $recommendations = $contentBased->concat($collaborative)
                ->unique('id');
        } else {
            $recommendations = $contentBased;
        }

        // If still not enough, add popular destinations
        if ($recommendations->count() < $limit) {
            $popular = $this->getPopularDestinations($limit - $recommendations->count());
            $popular = $popular->map(function ($dest) {
                $dest->recommendation_type = 'popular';

                return $dest;
            });

            $recommendations = $recommendations->concat($popular)
                ->unique('id');
        }

        return $recommendations->take($limit)->values();
    }

    /**
     * Get recommendations for users who liked a specific destination.
     */
    public function getUsersAlsoLiked(int $destinationId, int $limit = 10): Collection
    {
        // Find users who liked this destination
        $usersWhoLiked = DestinationLike::where('destination_id', $destinationId)
            ->pluck('user_id');

        if ($usersWhoLiked->isEmpty()) {
            return $this->getPopularDestinations($limit);
        }

        // Find other destinations these users also liked
        $alsoLikedDestinations = DestinationLike::whereIn('user_id', $usersWhoLiked)
            ->where('destination_id', '!=', $destinationId)
            ->select('destination_id', DB::raw('COUNT(*) as like_count'))
            ->groupBy('destination_id')
            ->orderByDesc('like_count')
            ->limit($limit)
            ->get();

        // Load full destination data
        $destinations = Destination::with(['preference', 'province', 'category'])
            ->whereIn('id', $alsoLikedDestinations->pluck('destination_id'))
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->get();

        // Add like count to each destination
        $destinations = $destinations->map(function ($destination) use ($alsoLikedDestinations) {
            $likeData = $alsoLikedDestinations->firstWhere('destination_id', $destination->id);
            $destination->also_liked_count = $likeData ? $likeData->like_count : 0;

            return $destination;
        });

        return $destinations->sortByDesc('also_liked_count')->values();
    }
}
