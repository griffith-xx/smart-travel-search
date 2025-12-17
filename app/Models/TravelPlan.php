<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TravelPlan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'start_date',
        'end_date',
        'total_budget',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'total_budget' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(TravelPlanItem::class)->orderBy('day_number')->orderBy('order');
    }

    public function getTotalDaysAttribute(): int
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    public function getTotalEstimatedCostAttribute(): float
    {
        return $this->items()->sum('estimated_cost') ?? 0;
    }
}
