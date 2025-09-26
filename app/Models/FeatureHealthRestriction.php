<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureHealthRestriction extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
    ];
}
