<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    // Fillable attributes for mass assignment
    protected $fillable = [
        'user_id',
        'preference_type',
        'preference_value',
        'weight'
    ];
}
