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
        if(!Schema::hasTable('user_comments')) {
            Schema::create('user_comments', function (Blueprint $table) {
                $table->id('users_comment_id');

                $table->foreignId('recipe_id')
                    ->constrained('recipes', 'recipes_id')
                    ->onDelete('cascade');

                $table->foreignId('profile_id')
                    ->constrained('user_profile', 'user_profile_id')
                    ->onDelete('cascade');

                $table->foreignId('parent_comment_id')
                    ->nullable()
                    ->constrained('user_comments', 'users_comment_id')
                    ->onDelete('cascade');

                $table->text('content');

                $table->boolean('is_verified')->default(false);
                $table->bigInteger('react_count')->default(0);

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_comments');
    }
};
