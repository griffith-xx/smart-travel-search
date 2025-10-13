<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DestinationPreference extends Model
{
    protected $fillable = [
        'destination_id',
        'wellness_goals',
        'activities',
        'environments',
        'duration_intensity_id',
        'budget_accommodation_id',
        'keywords',
    ];

    protected $casts = [
        'wellness_goals' => 'array',
        'activities' => 'array',
        'environments' => 'array',
        'duration_intensity_id' => 'integer',
        'budget_accommodation_id' => 'integer',
        'keywords' => 'array',
    ];

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function getWellnessGoalFeaturesAttribute()
    {
        if (empty($this->wellness_goals)) {
            return collect();
        }

        return FeatureWellnessGoal::whereIn('id', $this->wellness_goals)->get();
    }

    public function getActivityFeaturesAttribute()
    {
        if (empty($this->activities)) {
            return collect();
        }

        return FeatureActivity::whereIn('id', $this->activities)->get();
    }

    public function getEnvironmentFeaturesAttribute()
    {
        if (empty($this->environments)) {
            return collect();
        }

        return FeatureEnvironment::whereIn('id', $this->environments)->get();
    }

    public function durationIntensity(): BelongsTo
    {
        return $this->belongsTo(FeatureDurationIntensity::class);
    }

    public function budgetAccommodation(): BelongsTo
    {
        return $this->belongsTo(FeatureBudgetAccommodation::class);
    }

    public function getAllFeatures()
    {
        return [
            'wellness_goals' => $this->wellness_goal_features,
            'activities' => $this->activity_features,
            'environments' => $this->environment_features,
            'duration_intensity' => $this->durationIntensity,
            'budget_accommodation' => $this->budgetAccommodation,
            'keywords' => $this->keywords,
        ];
    }

    public function loadAllFeatures()
    {
        $this->load(['durationIntensity', 'budgetAccommodation']);

        return $this->getAllFeatures();
    }
}
