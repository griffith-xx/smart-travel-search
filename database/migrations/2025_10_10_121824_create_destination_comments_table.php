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
        Schema::create('destination_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('destination_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('destination_comments')->onDelete('cascade'); // สำหรับ nested comments/replies

            // Content
            $table->text('content');
            $table->json('images')->nullable(); // รูปภาพแนบ (optional)

            // Engagement
            $table->integer('likes_count')->default(0); // จำนวนคนกด like comment
            $table->integer('replies_count')->default(0); // จำนวน replies

            // Moderation
            $table->boolean('is_approved')->default(true); // สำหรับ moderation (ถ้าต้องการ)
            $table->boolean('is_edited')->default(false); // แสดงว่ามีการแก้ไข
            $table->timestamp('edited_at')->nullable();

            // Soft delete สำหรับกรณีที่ user ลบคอมเม้นท์
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index('user_id');
            $table->index('destination_id');
            $table->index('parent_id');
            $table->index(['destination_id', 'created_at']); // composite index สำหรับดึงคอมเม้นท์ล่าสุด
            $table->index('is_approved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destination_comments');
    }
};
