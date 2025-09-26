<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureWellnessExperience extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
    ];
}
