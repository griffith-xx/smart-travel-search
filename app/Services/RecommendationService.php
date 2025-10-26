<?php

namespace App\Services;

use App\Models\Destination;
use App\Models\DestinationLike;
use App\Models\User;
use Illuminate\Support\Collection;

class RecommendationService
{
    /**
     * Get personalized recommendations based on user preferences.
     */
    public function getPersonalizedRecommendations(User $user, int $limit = 10): Collection
    {
        $userPreference = $user->preference;

        if (! $userPreference) {
            return collect([]);
        }

        $destinations = Destination::with(['preference', 'category', 'province'])
            ->whereNotNull('published_at')
            ->get();

        $recommendations = $destinations->map(function ($destination) use ($userPreference) {
            $destinationPref = $destination->preference;

            if (! $destinationPref) {
                return null;
            }

            $score = $this->calculateMatchingScore($userPreference, $destinationPref);

            return [
                'destination' => $destination,
                'score' => $score,
                'match_percentage' => round($score * 100, 2),
            ];
        })
            ->filter(fn ($item) => $item !== null && $item['score'] > 0)
            ->sortByDesc('score')
            ->take($limit)
            ->values();

        return $recommendations;
    }

    /**
     * Calculate matching score between user and destination preferences.
     */
    protected function calculateMatchingScore($userPref, $destinationPref): float
    {
        $score = 0;
        $maxScore = 0;

        // Wellness Goals (weight: 3)
        $wellnessWeight = 3;
        if (is_array($userPref->wellness_goals) && is_array($destinationPref->wellness_goals)) {
            $wellnessMatches = count(array_intersect($userPref->wellness_goals, $destinationPref->wellness_goals));
            $score += $wellnessMatches * $wellnessWeight;
            $maxScore += count($userPref->wellness_goals) * $wellnessWeight;
        }

        // Activities (weight: 2.5)
        $activitiesWeight = 2.5;
        if (is_array($userPref->activities) && is_array($destinationPref->activities)) {
            $activitiesMatches = count(array_intersect($userPref->activities, $destinationPref->activities));
            $score += $activitiesMatches * $activitiesWeight;
            $maxScore += count($userPref->activities) * $activitiesWeight;
        }

        // Environments (weight: 2)
        $environmentsWeight = 2;
        if (is_array($userPref->environments) && is_array($destinationPref->environments)) {
            $environmentsMatches = count(array_intersect($userPref->environments, $destinationPref->environments));
            $score += $environmentsMatches * $environmentsWeight;
            $maxScore += count($userPref->environments) * $environmentsWeight;
        }

        // Budget Accommodation (weight: 1.5)
        $budgetWeight = 1.5;
        if ($userPref->budget_accommodation_id && $destinationPref->budget_accommodation_id) {
            if ($userPref->budget_accommodation_id === $destinationPref->budget_accommodation_id) {
                $score += $budgetWeight;
            }
            $maxScore += $budgetWeight;
        }

        // Duration Intensity (weight: 1)
        $durationWeight = 1;
        if ($userPref->duration_intensity_id && $destinationPref->duration_intensity_id) {
            if ($userPref->duration_intensity_id === $destinationPref->duration_intensity_id) {
                $score += $durationWeight;
            }
            $maxScore += $durationWeight;
        }

        return $maxScore > 0 ? $score / $maxScore : 0;
    }

    /**
     * Get collaborative filtering recommendations based on similar users.
     */
    public function getCollaborativeRecommendations(User $user, int $limit = 10): Collection
    {
        // Get current user's liked destinations
        $userLikes = DestinationLike::where('user_id', $user->id)
            ->pluck('destination_id')
            ->toArray();

        if (empty($userLikes)) {
            return collect([]);
        }

        // Find similar users (users who liked the same destinations)
        $similarUsers = DestinationLike::whereIn('destination_id', $userLikes)
            ->where('user_id', '!=', $user->id)
            ->select('user_id')
            ->groupBy('user_id')
            ->get()
            ->pluck('user_id');

        if ($similarUsers->isEmpty()) {
            return collect([]);
        }

        // Calculate similarity scores for each user
        $userSimilarities = $similarUsers->map(function ($similarUserId) use ($userLikes) {
            $similarUserLikes = DestinationLike::where('user_id', $similarUserId)
                ->pluck('destination_id')
                ->toArray();

            $similarity = $this->calculateJaccardSimilarity($userLikes, $similarUserLikes);

            return [
                'user_id' => $similarUserId,
                'similarity' => $similarity,
                'likes' => $similarUserLikes,
            ];
        })
            ->sortByDesc('similarity')
            ->take(5); // Top 5 similar users

        // Get recommended destinations from similar users
        $recommendedDestinations = [];

        foreach ($userSimilarities as $similarUser) {
            $newDestinations = array_diff($similarUser['likes'], $userLikes);

            foreach ($newDestinations as $destinationId) {
                if (! isset($recommendedDestinations[$destinationId])) {
                    $recommendedDestinations[$destinationId] = 0;
                }
                $recommendedDestinations[$destinationId] += $similarUser['similarity'];
            }
        }

        arsort($recommendedDestinations);

        $destinationIds = array_slice(array_keys($recommendedDestinations), 0, $limit);

        $destinations = Destination::with(['category', 'province'])
            ->whereIn('id', $destinationIds)
            ->whereNotNull('published_at')
            ->get()
            ->map(function ($destination) use ($recommendedDestinations) {
                return [
                    'destination' => $destination,
                    'score' => $recommendedDestinations[$destination->id],
                ];
            })
            ->sortByDesc('score')
            ->values();

        return $destinations;
    }

    /**
     * Calculate Jaccard Similarity between two arrays.
     */
    protected function calculateJaccardSimilarity(array $set1, array $set2): float
    {
        $intersection = count(array_intersect($set1, $set2));
        $union = count(array_unique(array_merge($set1, $set2)));

        return $union > 0 ? $intersection / $union : 0;
    }

    /**
     * Get hybrid recommendations (combining personalized and collaborative).
     */
    public function getHybridRecommendations(User $user, int $limit = 10): Collection
    {
        // Check user interaction count
        $interactionCount = DestinationLike::where('user_id', $user->id)->count();

        // Determine weights based on interaction level
        if ($interactionCount === 0) {
            // New user - use personalized only
            $personalizedWeight = 1.0;
            $collaborativeWeight = 0.0;
        } elseif ($interactionCount < 5) {
            // Low interaction - prefer personalized
            $personalizedWeight = 0.7;
            $collaborativeWeight = 0.3;
        } else {
            // High interaction - prefer collaborative
            $personalizedWeight = 0.4;
            $collaborativeWeight = 0.6;
        }

        // Get both recommendation types
        $personalizedResults = $this->getPersonalizedRecommendations($user, 20);
        $collaborativeResults = $this->getCollaborativeRecommendations($user, 20);

        // Combine scores
        $combinedScores = [];

        foreach ($personalizedResults as $item) {
            $destId = $item['destination']->id;
            if (! isset($combinedScores[$destId])) {
                $combinedScores[$destId] = [
                    'destination' => $item['destination'],
                    'personalized_score' => 0,
                    'collaborative_score' => 0,
                ];
            }
            $combinedScores[$destId]['personalized_score'] = $item['score'];
        }

        foreach ($collaborativeResults as $item) {
            $destId = $item['destination']->id;
            if (! isset($combinedScores[$destId])) {
                $combinedScores[$destId] = [
                    'destination' => $item['destination'],
                    'personalized_score' => 0,
                    'collaborative_score' => 0,
                ];
            }
            $combinedScores[$destId]['collaborative_score'] = $item['score'];
        }

        // Calculate final scores
        $recommendations = collect($combinedScores)->map(function ($item) use ($personalizedWeight, $collaborativeWeight) {
            $finalScore = ($item['personalized_score'] * $personalizedWeight) +
                ($item['collaborative_score'] * $collaborativeWeight);

            return [
                'destination' => $item['destination'],
                'final_score' => $finalScore,
                'personalized_score' => $item['personalized_score'],
                'collaborative_score' => $item['collaborative_score'],
                'personalized_weight' => $personalizedWeight,
                'collaborative_weight' => $collaborativeWeight,
            ];
        })
            ->sortByDesc('final_score')
            ->take($limit)
            ->values();

        return $recommendations;
    }
}
