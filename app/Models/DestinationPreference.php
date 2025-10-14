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

    /**
     * Get the destination that owns the preference.
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }
}
