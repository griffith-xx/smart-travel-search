<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInteraction extends Model
{
    // Fillable attributes for mass assignment
    protected $fillable = [
        'user_id',
        'attraction_id',
        'interaction_type',
        'target_id',
        'rating',
        'comment',
        'metadata',
        'interaction_date'
    ];
}
