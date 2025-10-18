<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Services\RecommendationService;
use Inertia\Inertia;
use Inertia\Response;

class DestinationController extends Controller
{
    public function __construct(
        protected RecommendationService $recommendationService
    ) {}

    public function index(): Response
    {
        $destinations = Destination::query()
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->with(['province', 'category'])
            ->orderByDesc('published_at')
            ->paginate(12);

        return Inertia::render('User/Destinations/Index', [
            'destinations' => $destinations,
        ]);
    }

    public function recommended(): Response
    {
        $user = auth()->user();

        if (! $user || ! $user->preference) {
            return redirect()->route('destinations.index')
                ->with('message', 'กรุณากรอกความชอบของคุณเพื่อรับคำแนะนำสถานที่');
        }

        $recommendations = $this->recommendationService
            ->getHybridRecommendations($user, 20);

        return Inertia::render('User/Destinations/Recommended', [
            'recommendations' => $recommendations,
        ]);
    }

    public function saved(): Response
    {
        $user = auth()->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $savedDestinations = $user->likedDestinations()
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->with(['province', 'category'])
            ->orderByDesc('destination_likes.created_at')
            ->paginate(12);

        return Inertia::render('User/Destinations/Saved', [
            'destinations' => $savedDestinations,
        ]);
    }

    public function show(string $slug): Response
    {
        $destination = Destination::where('slug', $slug)
            ->with(['province', 'category'])
            ->firstOrFail();

        return Inertia::render('User/Destinations/Show', [
            'destination' => $destination,
        ]);
    }
}
