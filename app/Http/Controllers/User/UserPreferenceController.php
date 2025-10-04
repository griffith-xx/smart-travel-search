<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Inertia\Inertia;
use Illuminate\Http\Request;

use App\Models\FeatureWellnessGoal;
use App\Models\FeatureActivity;
use App\Models\FeatureEnvironment;
use App\Models\FeatureDurationIntensity;
use App\Models\FeatureBudgetAccommodation;
use App\Models\FeatureWellnessExperience;

class UserPreferenceController extends Controller
{
    public function index()
    {
        return Inertia::render('User/Preferences/Index');
    }

    public function create()
    {
        $featureWellnessGoals = FeatureWellnessGoal::get();
        $featureActivities = FeatureActivity::get();
        $FeatureEnvironments = FeatureEnvironment::get();
        $featureDurationIntensities = FeatureDurationIntensity::get();
        $featureBudgetAccommodations = FeatureBudgetAccommodation::get();
        $featureWellnessExperiences = FeatureWellnessExperience::get();

        return Inertia::render('User/Preferences/Create', [
            'featureWellnessGoals' => $featureWellnessGoals,
            'featureActivities' => $featureActivities,
            'featureEnvironments' => $FeatureEnvironments,
            'featureDurationIntensities' => $featureDurationIntensities,
            'featureBudgetAccommodations' => $featureBudgetAccommodations,
            'featureWellnessExperiences' => $featureWellnessExperiences,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'wellnessGoals' => 'array',
            'wellnessGoals.*' => 'exists:feature_wellness_goals,id',
            'activities' => 'array',
            'activities.*' => 'exists:feature_activities,id',
            'environments' => 'array',
            'environments.*' => 'exists:feature_environments,id',
            'durationIntensity' => 'nullable|exists:feature_duration_intensities,id',
            'budgetAccommodation' => 'nullable|exists:feature_budget_accommodations,id',
            'wellnessExperience' => 'nullable|exists:feature_wellness_experiences,id',
        ]);

        $preferences = [
            'wellness_goals' => $validated['wellnessGoals'],
            'activities' => $validated['activities'],
            'environments' => $validated['environments'],
            'duration_intensity_id' => $validated['durationIntensity'],
            'budget_accommodation_id' => $validated['budgetAccommodation'],
            'wellness_experience_id' => $validated['wellnessExperience'],
        ];

        $user = auth()->user();
        $user->preference()->create($preferences);

        return redirect()->route('destinations.index')->with('flash', [
            'style' => 'success',
            'message' => 'ขอบคุณที่กรอกข้อมูลความชอบของคุณ! เราจะใช้ข้อมูลนี้เพื่อแนะนำจุดหมายปลายทางที่เหมาะสมกับคุณมากขึ้น',
        ]);
    }
}
