<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = [
        'name',
        'name_en',
        'description',
        'region',
        'latitude',
        'longitude',
        'image_url',
        'is_popular',
        'sort_order',
    ];

    protected $casts = [
        'is_popular' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function destinations()
    {
        return $this->hasMany(Destination::class);
    }
}
