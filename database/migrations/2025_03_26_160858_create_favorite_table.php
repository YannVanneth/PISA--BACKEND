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
        Schema::create('recipes_favorite', function (Blueprint $table) {
            $table->id('recipes_favorite_id');
            $table->unsignedBigInteger('recipes_id')->constrained('recipes', 'recipes_id');
            $table->unsignedBigInteger('profile_id')->constrained('users', 'profile_id');
            $table->boolean('favorite_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes_favorite');
    }
};
