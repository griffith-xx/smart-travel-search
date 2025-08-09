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
        Schema::create('attractions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('province_id')->constrained()->cascadeOnDelete();

            // Basic Info
            $table->string('name_th');
            $table->string('name_en')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->text('description')->nullable();

            // Location
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Pricing & Time
            $table->tinyInteger('price_range')->default(1)
                ->comment('1=ฟรี, 2=ไม่แพง(1-200), 3=ปานกลาง(201-500), 4=แพง(500+)');
            $table->text('pricing_info')->nullable();
            $table->string('operating_hours', 100)->nullable();
            $table->enum('best_visit_time', ['morning', 'afternoon', 'evening', 'night', 'all_day'])
                ->default('all_day')
                ->comment('morning=เช้า, afternoon=บ่าย, evening=เย็น, night=กลางคืน, all_day=ทั้งวัน');

            // Experience
            $table->tinyInteger('crowd_level')->default(3)
                ->comment('1=เงียบมาก, 2=เงียบ, 3=ปานกลาง, 4=คนเยอะ, 5=แออัดมาก');
            $table->tinyInteger('accessibility_level')->default(3)
                ->comment('1=ยากมาก, 2=ยาก, 3=ปานกลาง, 4=ง่าย, 5=ง่ายมาก');

            // Media & Rating
            $table->text('featured_image')->nullable();
            $table->json('gallery')->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->unsignedInteger('review_count')->default(0);

            // Status
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes
            $table->index(['category_id', 'province_id']);
            $table->index(['latitude', 'longitude']);
            $table->index(['is_active', 'rating']);
            $table->fullText(['name_th', 'name_en', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attractions');
    }
};
