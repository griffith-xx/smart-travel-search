<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Database\Seeder;

class UserPreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->count() >= 3) {
            // User 1 - Develop User (Yoga & Nature lover)
            UserPreference::create([
                'user_id' => $users[0]->id,
                'wellness_goals' => [1, 3, 5], // relax_and_stress_relief, mental_health_care, nature_and_body_recovery
                'activities' => [1, 2, 4], // yoga_meditation, massage_spa_treatment, detox_healthy_nutrition
                'environments' => [1, 2, 3], // forest_and_nature, mountain_and_highland, beach_and_island
                'duration_intensity_id' => 2, // moderate_recovery
                'budget_accommodation_id' => 2, // moderate_budget
                'wellness_experience_id' => 1,
                'keywords' => [1, 2, 8, 10, 11], // relaxation, nature, meditation, spa, yoga
            ]);

            // User 2 - Somchai Wellness (Luxury spa enthusiast)
            UserPreference::create([
                'user_id' => $users[1]->id,
                'wellness_goals' => [4, 1], // massage_and_spa, relax_and_stress_relief
                'activities' => [2], // massage_spa_treatment
                'environments' => [3], // beach_and_island
                'duration_intensity_id' => 1, // short_relaxation
                'budget_accommodation_id' => 4, // luxury_budget
                'wellness_experience_id' => 2,
                'keywords' => [3, 10, 9, 4], // luxury, spa, thai-massage, organic
            ]);

            // User 3 - Preeda Relax (Budget-friendly nature seeker)
            UserPreference::create([
                'user_id' => $users[2]->id,
                'wellness_goals' => [5, 1], // nature_and_body_recovery, relax_and_stress_relief
                'activities' => [5, 3], // herbal_natural_healing, nature_fitness
                'environments' => [1, 5], // forest_and_nature, waterfall_and_stream
                'duration_intensity_id' => 1, // short_relaxation
                'budget_accommodation_id' => 1, // budget_friendly
                'wellness_experience_id' => 1,
                'keywords' => [12, 2, 5, 1], // hot-spring, nature, herbal, relaxation
            ]);
        }
    }
}
