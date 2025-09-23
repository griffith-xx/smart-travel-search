<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureWellnessGoal extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];
}
