<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttractionAttribute extends Model
{
    // Fillable attributes for mass assignment
    protected $fillable = [
        'attraction_id',
        'attribute_type_id',
        'is_available',
        'notes',
    ];
}
