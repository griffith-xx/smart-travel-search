<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TravelPlanItem extends Model
{
    protected $fillable = [
        'travel_plan_id',
        'destination_id',
        'day_number',
        'order',
        'notes',
        'estimated_cost',
    ];

    protected function casts(): array
    {
        return [
            'estimated_cost' => 'decimal:2',
        ];
    }

    public function travelPlan(): BelongsTo
    {
        return $this->belongsTo(TravelPlan::class);
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }
}
