<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureTravelCompanion extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
    ];
}
