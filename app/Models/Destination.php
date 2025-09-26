<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = [
        'province_id',
        'name',
        'slug',
        'name_en',
        'description',
        'latitude',
        'longitude',
        'address',
        'cover_image',
        'gallery_images',
        'wellness_goals',
        'activities',
        'environments',
        'health_restrictions',
        'duration_intensity_id',
        'budget_accommodation_id',
        'travel_companion_id',
        'wellness_experience_id',
        'price_from',
        'price_to',
        'is_active',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'gallery_images' => 'array',
        'wellness_goals' => 'array',
        'activities' => 'array',
        'environments' => 'array',
        'health_restrictions' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
