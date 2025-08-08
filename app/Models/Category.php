<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Fillable attributes for mass assignment
    protected $fillable = [
        'name_th',
        'name_en',
        'parent_category_id',
        'icon',
        'description',
    ];

    // Parent relationship
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    // Children relationship
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }

    // Attactions relationship
    public function attractions()
    {
        return $this->hasMany(Attraction::class);
    }
}
