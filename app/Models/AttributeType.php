<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeType extends Model
{
    // Fillable attributes for mass assignment
    protected $fillable = [
        'name',
        'display_name_th',
        'display_name_en',
        'icon',
        'category',
        'is_active',
    ];
}
