<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class Destination extends Model
{
    protected $fillable = [
        'name',
        'description',
        'wellness_goals',
    ];

    protected $casts = [
        'wellness_goals' => 'array',
    ];

    /**
     * Content-based recommendation algorithm for destinations
     * based on user's wellness goals preferences
     */
    public static function getRecommendations(array $userWellnessGoals, int $limit = 10): SupportCollection
    {
        $destinations = self::all();
        $recommendations = [];

        foreach ($destinations as $destination) {
            $score = self::calculateSimilarityScore($userWellnessGoals, $destination->wellness_goals ?? []);
            
            if ($score > 0) {
                $matchingGoals = self::getMatchingGoals($userWellnessGoals, $destination->wellness_goals ?? []);
                
                $recommendations[] = [
                    'destination' => $destination,
                    'similarity_score' => round($score, 3),
                    'matching_goals' => $matchingGoals,
                    'matching_count' => count($matchingGoals),
                    'total_destination_goals' => count($destination->wellness_goals ?? []),
                    'match_percentage' => count($userWellnessGoals) > 0 ? round((count($matchingGoals) / count($userWellnessGoals)) * 100, 1) : 0,
                    'wellness_goals_with_names' => $destination->getWellnessGoalsWithNames()
                ];
            }
        }

        // Sort by score (highest first)
        usort($recommendations, function ($a, $b) {
            return $b['similarity_score'] <=> $a['similarity_score'];
        });

        // Return complete recommendation data with scores
        return collect(array_slice($recommendations, 0, $limit));
    }

    /**
     * Calculate similarity score between user preferences and destination wellness goals
     */
    private static function calculateSimilarityScore(array $userGoals, array $destinationGoals): float
    {
        if (empty($userGoals) || empty($destinationGoals)) {
            return 0;
        }

        $intersection = array_intersect($userGoals, $destinationGoals);
        $union = array_unique(array_merge($userGoals, $destinationGoals));

        // Jaccard similarity coefficient
        return count($intersection) / count($union);
    }

    /**
     * Get matching wellness goals between user and destination
     */
    private static function getMatchingGoals(array $userGoals, array $destinationGoals): array
    {
        return array_intersect($userGoals, $destinationGoals);
    }

    /**
     * Get destinations that match specific wellness goal
     */
    public static function getByWellnessGoal(string $wellnessGoal): Collection
    {
        return self::whereJsonContains('wellness_goals', $wellnessGoal)->get();
    }

    /**
     * Get destinations that match any of the provided wellness goals
     */
    public static function getByAnyWellnessGoals(array $wellnessGoals): Collection
    {
        $query = self::query();
        
        foreach ($wellnessGoals as $goal) {
            $query->orWhereJsonContains('wellness_goals', $goal);
        }
        
        return $query->get();
    }

    /**
     * Get detailed recommendations with scores and matching information
     */
    public static function getDetailedRecommendations(array $userWellnessGoals, int $limit = 10): array
    {
        $destinations = self::all();
        $recommendations = [];

        foreach ($destinations as $destination) {
            $destinationGoals = $destination->wellness_goals ?? [];
            $score = self::calculateSimilarityScore($userWellnessGoals, $destinationGoals);
            
            if ($score > 0) {
                $matchingGoals = self::getMatchingGoals($userWellnessGoals, $destinationGoals);
                
                $recommendations[] = [
                    'destination' => $destination,
                    'similarity_score' => round($score, 3),
                    'matching_goals' => $matchingGoals,
                    'matching_count' => count($matchingGoals),
                    'total_destination_goals' => count($destinationGoals),
                    'match_percentage' => round((count($matchingGoals) / count($userWellnessGoals)) * 100, 1)
                ];
            }
        }

        // Sort by similarity score (highest first)
        usort($recommendations, function ($a, $b) {
            return $b['similarity_score'] <=> $a['similarity_score'];
        });

        return array_slice($recommendations, 0, $limit);
    }

    /**
     * Get wellness goals statistics for this destination
     */
    public function getWellnessGoalsStats(): array
    {
        $goals = $this->wellness_goals ?? [];
        
        return [
            'total_goals' => count($goals),
            'goals_list' => $goals,
            'goals_with_names' => $this->getWellnessGoalsWithNames()
        ];
    }

    /**
     * Get wellness goals with their full names from FeatureWellnessGoal model
     */
    public function getWellnessGoalsWithNames(): array
    {
        if (empty($this->wellness_goals)) {
            return [];
        }

        return \App\Models\FeatureWellnessGoal::whereIn('slug', $this->wellness_goals)
            ->get(['slug', 'name', 'description'])
            ->toArray();
    }
}