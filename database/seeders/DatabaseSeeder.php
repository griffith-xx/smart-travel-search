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
            FeatureWellnessGoalSeeder::class,
            FeatureActivitySeeder::class,
            FeatureBudgetAccommodationSeeder::class,
            FeatureDurationIntensitySeeder::class,
            FeatureEnvironmentSeeder::class,
            FeatureWellnessExperienceSeeder::class,
        ]);
    }
}
