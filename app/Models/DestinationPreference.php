<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationPreference extends Model
{
    protected $fillable = [
        'destination_id',
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
        'duration_intensity_id' => 'integer',
        'budget_accommodation_id' => 'integer',
        'wellness_experience_id' => 'integer',
    ];
}
