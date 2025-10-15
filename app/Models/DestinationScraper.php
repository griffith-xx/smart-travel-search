<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinationScraper extends Model
{
    protected $fillable = [
        'url',
        'body',
        'http_status_code',
    ];

    protected $casts = [
        'body' => 'json',
        'http_status_code' => 'integer',
    ];
}
