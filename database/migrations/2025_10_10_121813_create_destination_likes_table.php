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
        Schema::create('destination_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('destination_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Unique constraint - user สามารถ like destination ได้แค่ครั้งเดียว
            $table->unique(['user_id', 'destination_id']);

            // Indexes สำหรับ performance
            $table->index('user_id');
            $table->index('destination_id');
            $table->index('created_at'); // สำหรับเรียงลำดับ
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destination_likes');
    }
};
