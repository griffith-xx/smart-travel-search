<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Destination;
use Inertia\Inertia;

class MapController extends Controller
{
    public function index()
    {
        $categories = Category::get();

        $destinations = Destination::with('category')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('is_active', true)
            ->select('id', 'name', 'slug', 'latitude', 'longitude', 'category_id', 'cover_image', 'address', 'province_id')
            ->get()
            ->map(function ($destination) {
                return [
                    'id' => $destination->id,
                    'name' => $destination->name,
                    'slug' => $destination->slug,
                    'latitude' => (float) $destination->latitude,
                    'longitude' => (float) $destination->longitude,
                    'category' => $destination->category ? [
                        'id' => $destination->category->id,
                        'name' => $destination->category->name,
                    ] : null,
                    'cover_image' => $destination->cover_image,
                    'address' => $destination->address,
                ];
            });

        return Inertia::render('User/Map', [
            'categories' => $categories,
            'destinations' => $destinations,
        ]);
    }
}
