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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('destination_id')->constrained()->onDelete('cascade');

            // Rating & Content
            $table->integer('rating')->unsigned(); // 1-5 stars
            $table->string('title')->nullable(); // Review title (optional)
            $table->text('comment'); // Review text
            $table->json('images')->nullable(); // Review images (optional)

            // Visit Information
            $table->date('visit_date')->nullable(); // When they visited
            $table->boolean('is_verified_visit')->default(false); // Verified visitor

            // Engagement
            $table->integer('helpful_count')->default(0); // How many found this helpful
            $table->integer('not_helpful_count')->default(0); // Not helpful votes

            // Moderation
            $table->boolean('is_approved')->default(true); // For moderation
            $table->boolean('is_featured')->default(false); // Featured review
            $table->boolean('is_edited')->default(false); // Was edited
            $table->timestamp('edited_at')->nullable();

            // Admin response
            $table->text('admin_response')->nullable();
            $table->timestamp('admin_response_at')->nullable();

            // Soft delete
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index('user_id');
            $table->index('destination_id');
            $table->index('rating');
            $table->index(['destination_id', 'is_approved', 'created_at']); // For listing reviews
            $table->index(['user_id', 'destination_id']); // Check if user already reviewed

            // Unique constraint: one review per user per destination
            $table->unique(['user_id', 'destination_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
