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
        Schema::create('user_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('attraction_id')->constrained()->onDelete('cascade');
            $table->enum('interaction_type', [
                'view',      // ดู/เข้าชม
                'like',      // ถูกใจ
                'dislike',   // ไม่ถูกใจ
                'favorite',  // เก็บเป็น favorite
                'visited',   // ไปแล้ว
                'want_to_go', // อยากไป
                'share',     // แชร์
                'review'     // รีวิว
            ]);
            $table->tinyInteger('rating')->nullable();
            $table->text('comment')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('interaction_date')->useCurrent();
            $table->timestamps();

            $table->index(['user_id', 'interaction_type']);
            $table->index(['attraction_id', 'interaction_type']);
            $table->index(['interaction_type', 'interaction_date']);
            $table->index(['user_id', 'attraction_id', 'interaction_type']);

            $table->unique(['user_id', 'attraction_id', 'interaction_type'], 'unique_user_attraction_interaction');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_interactions');
    }
};
