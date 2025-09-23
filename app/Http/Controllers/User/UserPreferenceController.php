<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FeatureWellnessGoal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserPreferenceController extends Controller
{
    public function create()
    {
        $featureWellnessGoals = FeatureWellnessGoal::get();

        return Inertia::render('User/Preferences', [
            'featureWellnessGoals' => $featureWellnessGoals,
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'wellness_goals' => 'required|array',
            'wellness_goals.*' => 'exists:feature_wellness_goals,id'
        ]);

        auth()->user()->preference()->create([
            'wellness_goals' => $validate['wellness_goals']
        ]);

        return redirect()->route('dashboard')->with('success', 'Preferences updated successfully.');
    }
}
