<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationLike extends Model
{
    protected $fillable = [
        'user_id',
        'destination_id',
    ];
}
