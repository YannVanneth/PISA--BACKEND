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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notifications_id');
            $table->string('title');
            $table->text('message');
            $table->string('type')->nullable();
            $table->boolean('is_global')->default(false);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        Schema::create('user_notifications', function (Blueprint $table) {
            $table->id('user_notifications_id');
            $table->foreignId('user_profile_id')->constrained('user_profile', 'user_profile_id')->onDelete('cascade');
            $table->foreignId('notification_id')->constrained('notifications', 'notifications_id')->onDelete('cascade');
            $table->boolean('is_read')->default(false);
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('user_notifications');
    }
};
