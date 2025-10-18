<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'name_en',
        'slug',
        'description',
        'image_url',
        'is_popular',
        'sort_order',
    ];

    protected $casts = [
        'is_popular' => 'boolean',
    ];

    public function destinations()
    {
        return $this->hasMany(Destination::class);
    }
}
