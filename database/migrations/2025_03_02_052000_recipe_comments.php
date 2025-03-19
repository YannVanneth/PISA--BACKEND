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
//        if (Schema::hasTable('recipes')) {
//            Schema::create('recipe_comments', function (Blueprint $table) {
//                $table->id('recipe_comments_id');
//                $table->foreignId('recipes_id')
//                    ->constrained('recipes', 'recipes_id');
//                $table->foreignId('profile_id')
//                    ->constrained('user_profiles', 'user_profile_id');
//                $table->text('comment_text');
//                $table->timestamps();
//            });
//        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
//        Schema::dropIfExists('recipe_comments');
    }
};
