<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationComment extends Model
{
    protected $fillable = [
        'user_id',
        'destination_id',
        'parent_id',
        'content',
        'images',
        'likes_count',
        'replies_count',
        'is_approved',
        'is_edited',
        'edited_at',
    ];

    protected $casts = [
        'images' => 'json',
        'is_approved' => 'boolean',
        'is_edited' => 'boolean',
        'edited_at' => 'datetime',
    ];
}
