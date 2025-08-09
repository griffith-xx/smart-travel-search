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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_th', 100);
            $table->string('name_en', 100)->nullable();
            $table->foreignId('parent_category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('icon', 10)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('parent_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
