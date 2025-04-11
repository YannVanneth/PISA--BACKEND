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
        if(!Schema::hasTable('comment_reactions')) {
            Schema::create('comment_reactions', function (Blueprint $table)
            {
                $table->id('comment_reactions_id');

                $table->foreignId('user_id')
                    ->constrained('user_profile', 'user_profile_id')
                    ->onDelete('cascade');

                $table->foreignId('comment_id')
                    ->constrained('user_comments', 'users_comment_id')
                    ->onDelete('cascade');

                $table->boolean('is_liked')->default(true);

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_reactions');
    }
};
