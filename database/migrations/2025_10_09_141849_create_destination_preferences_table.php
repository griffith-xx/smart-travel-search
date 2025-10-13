<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('destination_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->constrained()->onDelete('cascade');

            // Wellness Features - Multiple selections (JSON arrays)
            $table->json('wellness_goals')->nullable(); // [1,2,3]
            $table->json('activities')->nullable(); // [1,2,3]
            $table->json('environments')->nullable(); // [1,2,3]

            // Single selections (Foreign Keys)
            $table->foreignId('duration_intensity_id')->nullable()->constrained('feature_duration_intensities'); // มีระยะเวลาได้แค่แบบเดียว
            $table->foreignId('budget_accommodation_id')->nullable()->constrained('feature_budget_accommodations'); // มีระดับราคาได้แค่แบบเดียว

            // Search & Recommendation Features
            $table->json('keywords')->nullable(); // คำค้นหาที่เกี่ยวข้อง เช่น ["detox", "organic", "natural healing"]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destination_preferences');
    }
};
