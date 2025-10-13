<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    /**
     * Get the destination that owns the preference.
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    /**
     * Get wellness goals details.
     */
    public function wellnessGoalsDetails(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->wellness_goals)) {
                    return collect([]);
                }

                return FeatureWellnessGoal::whereIn('id', $this->wellness_goals)->get();
            }
        );
    }

    /**
     * Get activities details.
     */
    public function activitiesDetails(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->activities)) {
                    return collect([]);
                }

                return FeatureActivity::whereIn('id', $this->activities)->get();
            }
        );
    }

    /**
     * Get environments details.
     */
    public function environmentsDetails(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->environments)) {
                    return collect([]);
                }

                return FeatureEnvironment::whereIn('id', $this->environments)->get();
            }
        );
    }
}
