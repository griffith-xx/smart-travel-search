<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attraction extends Model
{
    // Fillable attributes for mass assignment
    protected $fillable = [
        'category_id',
        'province_id',
        'name_th',
        'name_en',
        'slug',
        'description',
        'address',
        'latitude',
        'longitude',
        'price_range',
        'pricing_info',
        'operating_hours',
        'best_visit_time',
        'crowd_level',
        'accessibility_level',
        'featured_image',
        'gallery',
        'rating',
        'review_count',
        'is_active',
    ];

    // Cast attributes to specific types
    protected $casts = [
        // Boolean
        'is_active' => 'boolean',

        // Numbers
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'rating' => 'decimal:2',
        'review_count' => 'integer',
        'price_range' => 'integer',
        'crowd_level' => 'integer',
        'accessibility_level' => 'integer',

        // JSON
        'gallery' => 'array',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
