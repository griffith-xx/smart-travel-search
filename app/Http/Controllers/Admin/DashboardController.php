<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Destination;
use App\Models\DestinationComment;
use App\Models\DestinationLike;
use App\Models\Province;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic counts
        $totalProvinces = Province::count();
        $totalDestinations = Destination::count();
        $activeDestinations = Destination::where('is_active', true)->count();
        $featuredDestinations = Destination::where('is_featured', true)->count();
        $totalUsers = User::count();
        $totalComments = DestinationComment::count();
        $totalCategories = Category::count();
        $totalLikes = DestinationLike::count();

        // Popular provinces count
        $popularProvinces = Province::where('is_popular', true)->count();

        // New users in last 30 days
        $newUsers = User::where('created_at', '>=', now()->subDays(30))->count();

        // New comments in last 30 days
        $newComments = DestinationComment::where('created_at', '>=', now()->subDays(30))->count();

        // Recent destinations
        $recentDestinations = Destination::with(['province', 'category'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($destination) {
                return [
                    'id' => $destination->id,
                    'name' => $destination->name,
                    'province_name' => $destination->province?->name,
                    'category_name' => $destination->category?->name,
                    'is_active' => $destination->is_active,
                    'is_featured' => $destination->is_featured,
                    'created_at' => $destination->created_at,
                ];
            });

        // Recent users
        $recentUsers = User::latest()
            ->take(5)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'profile_photo_url' => $user->profile_photo_url,
                    'created_at' => $user->created_at,
                ];
            });

        // Top liked destinations
        $topDestinations = Destination::withCount('likes')
            ->with('province')
            ->orderBy('likes_count', 'desc')
            ->take(5)
            ->get()
            ->map(function ($destination) {
                return [
                    'id' => $destination->id,
                    'name' => $destination->name,
                    'province_name' => $destination->province?->name,
                    'likes_count' => $destination->likes_count,
                    'cover_image' => $destination->cover_image,
                ];
            });

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'provinces' => [
                    'total' => $totalProvinces,
                    'popular' => $popularProvinces,
                ],
                'destinations' => [
                    'total' => $totalDestinations,
                    'active' => $activeDestinations,
                    'featured' => $featuredDestinations,
                ],
                'users' => [
                    'total' => $totalUsers,
                    'new' => $newUsers,
                ],
                'comments' => [
                    'total' => $totalComments,
                    'new' => $newComments,
                ],
                'categories' => [
                    'total' => $totalCategories,
                ],
                'likes' => [
                    'total' => $totalLikes,
                ],
            ],
            'recentDestinations' => $recentDestinations,
            'recentUsers' => $recentUsers,
            'topDestinations' => $topDestinations,
        ]);
    }
}
