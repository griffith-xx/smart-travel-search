<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationPreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $preferences = [
            // 1. Divana Spa - Bangkok (Spa & Massage)
            [
                'destination_name' => 'Divana Spa',
                'wellness_goals' => [1, 4], // relax_and_stress_relief, massage_and_spa
                'activities' => [2], // massage_spa_treatment
                'environments' => [], // Urban spa
                'duration_intensity_id' => 1, // short_relaxation
                'budget_accommodation_id' => 2, // moderate_budget
                'keywords' => [1, 10, 9, 3], // relaxation, spa, thai-massage, luxury
            ],

            // 2. Yoga Retreat Chiang Mai (Yoga & Meditation)
            [
                'destination_name' => 'Yoga Retreat Chiang Mai',
                'wellness_goals' => [1, 3], // relax_and_stress_relief, mental_health_care
                'activities' => [1, 4], // yoga_meditation, detox_healthy_nutrition
                'environments' => [1, 2], // forest_and_nature, mountain_and_highland
                'duration_intensity_id' => 2, // moderate_recovery
                'budget_accommodation_id' => 2, // moderate_budget
                'keywords' => [11, 8, 2, 6], // yoga, meditation, nature, detox
            ],

            // 3. Hin Dad Hot Spring - Kanchanaburi
            [
                'destination_name' => 'Hin Dad Hot Spring',
                'wellness_goals' => [5, 1], // nature_and_body_recovery, relax_and_stress_relief
                'activities' => [5, 3], // herbal_natural_healing, nature_fitness
                'environments' => [1, 5], // forest_and_nature, waterfall_and_stream
                'duration_intensity_id' => 1, // short_relaxation
                'budget_accommodation_id' => 1, // budget_friendly
                'keywords' => [12, 2, 5, 1], // hot-spring, nature, herbal, relaxation
            ],

            // 4. Wellness Resort Phuket (Health & Wellness Retreat)
            [
                'destination_name' => 'Wellness Resort Phuket',
                'wellness_goals' => [5, 2, 3], // nature_and_body_recovery, exercise_and_fitness, mental_health_care
                'activities' => [4, 1, 3], // detox_healthy_nutrition, yoga_meditation, nature_fitness
                'environments' => [3], // beach_and_island
                'duration_intensity_id' => 3, // intensive_transformation
                'budget_accommodation_id' => 4, // luxury_budget
                'keywords' => [6, 7, 11, 3, 4], // detox, weight-loss, yoga, luxury, organic
            ],

            // 5. Nature Spa Resort - Chiang Mai (Hotel & Spa)
            [
                'destination_name' => 'Nature Spa Resort',
                'wellness_goals' => [1, 4, 5], // relax_and_stress_relief, massage_and_spa, nature_and_body_recovery
                'activities' => [2, 1], // massage_spa_treatment, yoga_meditation
                'environments' => [1], // forest_and_nature
                'duration_intensity_id' => 2, // moderate_recovery
                'budget_accommodation_id' => 3, // premium_budget
                'keywords' => [10, 2, 1, 11], // spa, nature, relaxation, yoga
            ],

            // 6. Railay Wellness Spa - Krabi
            [
                'destination_name' => 'Railay Wellness Spa',
                'wellness_goals' => [1, 4], // relax_and_stress_relief, massage_and_spa
                'activities' => [2, 1], // massage_spa_treatment, yoga_meditation
                'environments' => [3], // beach_and_island
                'duration_intensity_id' => 1, // short_relaxation
                'budget_accommodation_id' => 2, // moderate_budget
                'keywords' => [10, 9, 11, 1], // spa, thai-massage, yoga, relaxation
            ],

            // 7. Yoga & Meditation Studio Bangkok
            [
                'destination_name' => 'Yoga & Meditation Studio Bangkok',
                'wellness_goals' => [3, 1, 2], // mental_health_care, relax_and_stress_relief, exercise_and_fitness
                'activities' => [1], // yoga_meditation
                'environments' => [], // Urban studio
                'duration_intensity_id' => 1, // short_relaxation
                'budget_accommodation_id' => 1, // budget_friendly
                'keywords' => [11, 8, 1], // yoga, meditation, relaxation
            ],

            // 8. Luxury Spa Phuket
            [
                'destination_name' => 'Luxury Spa Phuket',
                'wellness_goals' => [4, 1], // massage_and_spa, relax_and_stress_relief
                'activities' => [2], // massage_spa_treatment
                'environments' => [3], // beach_and_island
                'duration_intensity_id' => 1, // short_relaxation
                'budget_accommodation_id' => 4, // luxury_budget
                'keywords' => [10, 3, 9, 4], // spa, luxury, thai-massage, organic
            ],
        ];

        foreach ($preferences as $index => $preferenceData) {
            $destination = Destination::where('name_en', 'LIKE', '%'.$preferenceData['destination_name'].'%')->first();

            if ($destination && $destination->preference) {
                $destination->preference->update([
                    'wellness_goals' => $preferenceData['wellness_goals'],
                    'activities' => $preferenceData['activities'],
                    'environments' => $preferenceData['environments'],
                    'duration_intensity_id' => $preferenceData['duration_intensity_id'],
                    'budget_accommodation_id' => $preferenceData['budget_accommodation_id'],
                    'keywords' => $preferenceData['keywords'],
                ]);
            }
        }
    }
}
