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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();

            // Basic Info
            $table->foreignId('province_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('name_en')->nullable();
            $table->text('description')->nullable();

            // Location & Basic Info
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('address')->nullable();
            $table->text('cover_image')->nullable();
            $table->json('gallery_images')->nullable();

            // Wellness Features - Multiple selections (JSON arrays)
            $table->json('wellness_goals')->nullable(); // สามารถมีหลายเป้าหมาย
            $table->json('activities')->nullable(); // สามารถมีหลายกิจกรรม
            $table->json('environments')->nullable(); // สามารถมีหลายสภาพแวดล้อม
            $table->json('health_restrictions')->nullable(); // สามารถมีหลายข้อจำกัด

            // Single selections (Foreign Keys)
            $table->foreignId('duration_intensity_id')->nullable()->constrained('feature_duration_intensities'); // มีระยะเวลาได้แค่แบบเดียว
            $table->foreignId('budget_accommodation_id')->nullable()->constrained('feature_budget_accommodations'); // มีระดับราคาได้แค่แบบเดียว
            $table->foreignId('travel_companion_id')->nullable()->constrained('feature_travel_companions'); // เหมาะกับกลุ่มเป้าหมายแค่แบบเดียว
            $table->foreignId('wellness_experience_id')->nullable()->constrained('feature_wellness_experiences'); // มีระดับประสบการณ์ได้แค่แบบเดียว

            // Pricing & Availability
            $table->decimal('price_from', 10, 2)->nullable();
            $table->decimal('price_to', 10, 2)->nullable();

            // Status & Metadata
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
