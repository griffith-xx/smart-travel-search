<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureActivity extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];
}
