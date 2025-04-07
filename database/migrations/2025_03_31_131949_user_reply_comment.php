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
//        Schema::create('user_reply_comment', function (Blueprint $table) {
//            $table->id('user_reply_comment_id');
//            $table->foreignId('comment_id')
//                ->constrained('users_comment','users_comment_id');
//            $table->foreignId('profile_id')
//                ->constrained('user_profile', 'user_profile_id');
//            $table->foreignId('recipe_id')
//                ->constrained('recipes', 'recipes_id');
//            $table->foreignId('reply_to_profile_id')
//                ->constrained('users_profile', 'user_profile_id');
//            $table->boolean('is_verified')->default(false);
//            $table->boolean('is_liked')->default(false);
//            $table->bigInteger('react_count')->default(0);
//            $table->string('reply_content');
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_reply_comment');
    }
};
