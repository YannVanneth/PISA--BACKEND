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
        Schema::create('user_reacted_comments', function (Blueprint $table) {
            $table->id('user_reacted_comments');
            $table->foreignId('recipe_id')->constrained('recipes', 'recipes_id');
            $table->foreignId('user_profile_id')->constrained('user_profile', 'user_profile_id');
            $table->foreignId('comment_id')->constrained('users_comment', 'users_comment_id');
            $table->boolean('reaction');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_reacted_comments');
    }
};
