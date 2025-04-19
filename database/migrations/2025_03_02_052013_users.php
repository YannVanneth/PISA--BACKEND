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
            $table->string('image_url')->nullable();
            $table->string('email');
            $table->string('password');
            $table->string('phone_number')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->string('otp_code')->nullable();
            $table->dateTime('otp_code_expire_at')->nullable();
            $table->string('provider')->nullable();
            $table->timestamps();
        });

        Schema::create('admin', function (Blueprint $table) {
            $table->id('admin_id')->primary();
            $table->string('username');
            $table->string('password');
            $table->string('email')->unique();
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

        Schema::create('recipes_rating', function (Blueprint $table) {
            $table->id('recipes_rating_id')->primary();
            $table->foreignId('recipes_id')
                ->constrained('recipes', 'recipes_id');
            $table->foreignId('profile_id')
                ->constrained('user_profile', 'user_profile_id');
            $table->double('rating_value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('recipes_rating');
        Schema::dropIfExists('social_login');
        Schema::dropIfExists('user_profile');
    }
};
