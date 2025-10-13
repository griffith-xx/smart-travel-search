<?php

namespace App\Models;

use App\Casts\FeatureDetailsCast;
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
        'wellness_goals' => FeatureDetailsCast::class . ':' . \App\Models\FeatureWellnessGoal::class,
        'activities' => FeatureDetailsCast::class . ':' . \App\Models\FeatureActivity::class,
        'environments' => FeatureDetailsCast::class . ':' . \App\Models\FeatureEnvironment::class,
        'duration_intensity_id' => 'integer',
        'budget_accommodation_id' => 'integer',
        'keywords' => 'array',
    ];

    /**
     * Get the destination that owns the preference.
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    /**
     * Get wellness goals IDs only (for recommendation system)
     */
    public function getWellnessGoalsIdsAttribute(): array
    {
        $value = $this->attributes['wellness_goals'] ?? null;

        if (empty($value)) {
            return [];
        }

        return is_string($value) ? json_decode($value, true) : [];
    }

    /**
     * Get activities IDs only (for recommendation system)
     */
    public function getActivitiesIdsAttribute(): array
    {
        $value = $this->attributes['activities'] ?? null;

        if (empty($value)) {
            return [];
        }

        return is_string($value) ? json_decode($value, true) : [];
    }

    /**
     * Get environments IDs only (for recommendation system)
     */
    public function getEnvironmentsIdsAttribute(): array
    {
        $value = $this->attributes['environments'] ?? null;

        if (empty($value)) {
            return [];
        }

        return is_string($value) ? json_decode($value, true) : [];
    }
}
