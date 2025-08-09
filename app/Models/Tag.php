<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // Fillable attributes for mass assignment
    protected $fillable = [
        'name',
        'display_name_th',
        'display_name_en',
        'group',
        'icon',
        'color',
    ];

    // Scope to filter by group
    public function scopeByGroup($query, $group)
    {
        return $query->where('group', $group);
    }

    // Accesor for name attribute
    public function getDisplayNameAttribute(): string
    {
        return $this->display_name_th ?? $this->display_name_en ?? $this->name;
    }

    // Mutator for name attribute (make it lowercase and replace spaces with underscores)
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower(str_replace(' ', '_', $value));
    }
}
