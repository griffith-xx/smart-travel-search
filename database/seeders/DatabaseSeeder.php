<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            ProvinceSeeder::class,
            CategorySeeder::class,
            FeatureWellnessGoalSeeder::class,
            FeatureActivitySeeder::class,
            FeatureBudgetAccommodationSeeder::class,
            FeatureDurationIntensitySeeder::class,
            FeatureEnvironmentSeeder::class,
            FeatureWellnessExperienceSeeder::class,
            FeatureKeywordSeeder::class,
            UserPreferenceSeeder::class,
            DestinationSeeder::class,
            DestinationPreferenceSeeder::class,
            ReviewSeeder::class,
            DestinationLikeSeeder::class,
            DestinationCommentSeeder::class,
            CommentLikeSeeder::class,
        ]);
    }
}
