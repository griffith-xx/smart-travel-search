<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FeatureActivity;
use App\Models\FeatureBudgetAccommodation;
use App\Models\FeatureDurationIntensity;
use App\Models\FeatureEnvironment;
use App\Models\FeatureWellnessExperience;
use App\Models\FeatureWellnessGoal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserPreferenceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $preference = $user->preference()->with([
            'durationIntensity',
            'budgetAccommodation',
            'wellnessExperience',
        ])->first();

        $preferenceData = null;
        if ($preference) {
            $preferenceData = [
                'id' => $preference->id,
                'wellness_goals' => FeatureWellnessGoal::whereIn('id', $preference->wellness_goals ?? [])->get(),
                'activities' => FeatureActivity::whereIn('id', $preference->activities ?? [])->get(),
                'environments' => FeatureEnvironment::whereIn('id', $preference->environments ?? [])->get(),
                'duration_intensity' => $preference->durationIntensity,
                'budget_accommodation' => $preference->budgetAccommodation,
                'wellness_experience' => $preference->wellnessExperience,
                'created_at' => $preference->created_at,
                'updated_at' => $preference->updated_at,
            ];
        }

        return Inertia::render('User/Preferences/Index', [
            'preference' => $preferenceData,
        ]);
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

    public function edit()
    {
        $user = auth()->user();
        $preference = $user->preference;

        if (! $preference) {
            return redirect()->route('preferences.create');
        }

        $featureWellnessGoals = FeatureWellnessGoal::get();
        $featureActivities = FeatureActivity::get();
        $featureEnvironments = FeatureEnvironment::get();
        $featureDurationIntensities = FeatureDurationIntensity::get();
        $featureBudgetAccommodations = FeatureBudgetAccommodation::get();
        $featureWellnessExperiences = FeatureWellnessExperience::get();

        return Inertia::render('User/Preferences/Edit', [
            'preference' => $preference,
            'featureWellnessGoals' => $featureWellnessGoals,
            'featureActivities' => $featureActivities,
            'featureEnvironments' => $featureEnvironments,
            'featureDurationIntensities' => $featureDurationIntensities,
            'featureBudgetAccommodations' => $featureBudgetAccommodations,
            'featureWellnessExperiences' => $featureWellnessExperiences,
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $preference = $user->preference;

        if (! $preference) {
            return redirect()->route('preferences.create');
        }

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

        $preference->update([
            'wellness_goals' => $validated['wellnessGoals'],
            'activities' => $validated['activities'],
            'environments' => $validated['environments'],
            'duration_intensity_id' => $validated['durationIntensity'],
            'budget_accommodation_id' => $validated['budgetAccommodation'],
            'wellness_experience_id' => $validated['wellnessExperience'],
        ]);

        return redirect()->route('preferences.index')->with('flash', [
            'style' => 'success',
            'message' => 'อัปเดตความชอบของคุณเรียบร้อยแล้ว!',
        ]);
    }
}
