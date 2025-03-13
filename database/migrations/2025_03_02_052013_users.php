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
        Schema::create('user_profile', function (Blueprint $table) {
            $table->id('user_profile_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('imageURL')->nullable();
            $table->string('email');
            $table->string('phone_number')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->string('otp_code')->nullable();
            $table->dateTime('otp_code_expire_at')->nullable();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id('users_id')->primary();
            $table->string('username');
            $table->string('password');
            $table->foreignId('profile_id')
                ->constrained('user_profile', 'user_profile_id');
            $table->timestamps();
        });

        Schema::create('social_login', function (Blueprint $table){
            $table->id('social_login_id');
            $table->string('social_login_provider')->nullable();
            $table->string('social_login_provider_id')->unique()->nullable();
            $table->foreignId('profile_id')
                ->constrained('user_profile', 'user_profile_id');
            $table->text('access_token');
            $table->timestamps();
        });

        Schema::create('users_comment', function (Blueprint $table) {
            $table->id('users_comment_id');
            $table->foreignId('recipe_id')
                ->constrained('recipes', 'recipes_id');
            $table->foreignId('profile_id')
                ->constrained('user_profile', 'user_profile_id');
            $table->string('comment_content');
            $table->timestamps();
        });

        Schema::create('recipes_rating', function (Blueprint $table) {
            $table->id('recipes_rating_id')->primary();
            $table->foreignId('recipes_id')
                ->constrained('recipes', 'recipes_id');
            $table->foreignId('profile_id')
                ->constrained('user_profile', 'user_profile_id');
            $table->double('rating_value');
        });

        Schema::create('recipes_favorite', function (Blueprint $table) {
            $table->id('recipes_favorite');
            $table->foreignId('recipes_id')
                ->constrained('recipes', 'recipes_id');
            $table->foreignId('profile_id')
                ->constrained('user_profile', 'user_profile_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('users_comment');
        Schema::dropIfExists('recipes_rating');
        Schema::dropIfExists('recipes_favorite');
        Schema::dropIfExists('social_login');
        Schema::dropIfExists('user_profile');
    }
};
