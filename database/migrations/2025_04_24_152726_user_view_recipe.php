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
        Schema::create('user_view_recipe', function (Blueprint $table){
            $table->id('user_view_recipe_id');
            $table->foreignId('user_profile_id')
                ->constrained('user_profile', 'user_profile_id')
                ->onDelete('cascade');
            $table->foreignId('recipe_id')
                ->constrained('recipes', 'recipes_id')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_view_recipe');
    }
};
