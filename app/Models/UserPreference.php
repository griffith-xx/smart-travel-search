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
        'health_restrictions',
        'duration_intensity_id',
        'budget_accommodation_id',
        'travel_companion_id',
        'wellness_experience_id',
    ];

    protected $casts = [
        'wellness_goals' => 'array',
        'activities' => 'array',
        'environments' => 'array',
        'health_restrictions' => 'array',
    ];
}
