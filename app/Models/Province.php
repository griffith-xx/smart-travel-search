<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    // Fillable attributes
    protected $fillable = [
        'province_name_th',
        'province_name_en',
        'region',
        'latitude',
        'longitude',
    ];

    // Scope to filter by region
    public function scopeByRegion($query, $region)
    {
        return $query->where('region', $region);
    }
}
