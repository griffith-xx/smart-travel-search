<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Destination;
use App\Models\Province;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class WelcomeController extends Controller
{
    public function index(): Response
    {
        // Get featured destinations
        $featuredDestinations = Destination::query()
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('is_featured', true)
            ->with(['province', 'category'])
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        // Get popular categories
        $categories = Category::query()
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        // Get statistics
        $stats = [
            'destinations' => Destination::where('is_active', true)
                ->whereNotNull('published_at')
                ->count(),
            'users' => User::count(),
            'provinces' => Province::count(),
            'reviews' => Destination::where('is_active', true)
                ->whereNotNull('published_at')
                ->sum('total_reviews'),
        ];

        return Inertia::render('Welcome', [
            'featuredDestinations' => $featuredDestinations,
            'categories' => $categories,
            'stats' => $stats,
        ]);
    }
}
