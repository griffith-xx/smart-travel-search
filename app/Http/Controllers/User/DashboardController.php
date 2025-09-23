<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Handle case where user might not have preferences set yet
        $userPreference = $user->preference;
        $wellnessGoals = $userPreference ? ($userPreference->wellness_goals ?? []) : [];

        // Get recommendations or fallback to popular destinations
        if (!empty($wellnessGoals)) {
            $recommendedDestinations = Destination::getRecommendations($wellnessGoals, 10);
        } else {
            // Fallback: show random or popular destinations when no preferences are set
            $recommendedDestinations = Destination::inRandomOrder()->limit(10)->get();
        }

        return Inertia::render('Dashboard', [
            'recommendedDestinations' => $recommendedDestinations,
            'hasPreferences' => !empty($wellnessGoals),
            'userWellnessGoals' => $wellnessGoals,
        ]);
    }
}
