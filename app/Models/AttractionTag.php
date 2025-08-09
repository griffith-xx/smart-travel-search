<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttractionTag extends Model
{
    // Fillable attributes for mass assignment
    protected $fillable = [
        'attraction_id',
        'tag_id',
        'relevance_score',
    ];
}
