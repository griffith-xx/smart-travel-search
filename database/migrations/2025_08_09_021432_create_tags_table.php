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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('display_name_th', 100);
            $table->string('display_name_en', 100)->nullable();
            $table->string('group', 50)->default('general');
            $table->string('icon', 10)->nullable();
            $table->string('color', 7)->default('#6B7280');
            $table->timestamps();

            $table->index(['group', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
