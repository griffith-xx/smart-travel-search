<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_url',
        'is_popular',
        'sort_order',
    ];

    protected $casts = [
        'is_popular' => 'boolean',
    ];
}
