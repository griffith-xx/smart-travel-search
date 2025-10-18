<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    protected $fillable = [
        'user_id',
        'wellness_goals',
        'activities',
        'environments',
        'duration_intensity_id',
        'budget_accommodation_id',
        'wellness_experience_id',
        'keywords',
    ];

    protected $casts = [
        'wellness_goals' => 'array',
        'activities' => 'array',
        'environments' => 'array',
        'keywords' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function durationIntensity()
    {
        return $this->belongsTo(FeatureDurationIntensity::class);
    }

    public function budgetAccommodation()
    {
        return $this->belongsTo(FeatureBudgetAccommodation::class);
    }

    public function wellnessExperience()
    {
        return $this->belongsTo(FeatureWellnessExperience::class);
    }
}
