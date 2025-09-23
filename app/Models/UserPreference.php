<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    protected $fillable = [
        'user_id',
        'wellness_goals',
    ];

    protected $casts = [
        'wellness_goals' => 'array',
    ];
}
