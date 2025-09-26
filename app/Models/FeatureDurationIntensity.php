<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureDurationIntensity extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
    ];
}
