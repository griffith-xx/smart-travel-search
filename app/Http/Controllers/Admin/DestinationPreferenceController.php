<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Inertia\Inertia;
use Illuminate\Http\Request;

use App\Models\Destination;
use App\Models\FeatureWellnessGoal;
use App\Models\FeatureActivity;
use App\Models\FeatureEnvironment;
use App\Models\FeatureDurationIntensity;
use App\Models\FeatureBudgetAccommodation;

class DestinationPreferenceController extends Controller
{
    public function edit(Destination $destination)
    {
        $featureWellnessGoals = FeatureWellnessGoal::get();
        $featureActivities = FeatureActivity::get();
        $FeatureEnvironments = FeatureEnvironment::get();
        $featureDurationIntensities = FeatureDurationIntensity::get();
        $featureBudgetAccommodations = FeatureBudgetAccommodation::get();

        return Inertia::render('Admin/Destinations/Preferences/Edit', [
            'destination' => $destination->with('preference')->first(),
            'featureWellnessGoals' => $featureWellnessGoals,
            'featureActivities' => $featureActivities,
            'featureEnvironments' => $FeatureEnvironments,
            'featureDurationIntensities' => $featureDurationIntensities,
            'featureBudgetAccommodations' => $featureBudgetAccommodations,
        ]);
    }

    public function update(Destination $destination, Request $request)
    {
        $validated = $request->validate([
            'wellnessGoals' => 'required|array',
            'wellnessGoals.*' => 'exists:feature_wellness_goals,id',
            'activities' => 'required|array',
            'activities.*' => 'exists:feature_activities,id',
            'environments' => 'required|array',
            'environments.*' => 'exists:feature_environments,id',
            'durationIntensity' => 'exists:feature_duration_intensities,id',
            'budgetAccommodation' => 'exists:feature_budget_accommodations,id',
            'keywords' => 'required|array',
            'keywords.*' => 'string',
        ]);

        $preferences = [
            'wellness_goals' => $validated['wellnessGoals'],
            'activities' => $validated['activities'],
            'environments' => $validated['environments'],
            'duration_intensity_id' => $validated['durationIntensity'],
            'budget_accommodation_id' => $validated['budgetAccommodation'],
            'keywords' => $validated['keywords'],
        ];

        $destination->preference()->update($preferences);

        return redirect()->route('admin.destinations.preferences.edit', $destination->id)
            ->with('flash', [
                'style' => 'success',
                'message' => 'เพิ่มความชอบสถานที่เรียบร้อยแล้ว',
            ]);
    }
}
