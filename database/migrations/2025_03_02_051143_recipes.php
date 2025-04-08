<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recipe_categories', function (Blueprint $table) {
            $table->id('recipe_categories_id');
            $table->string('recipe_categories_km');
            $table->string('recipe_categories_en');
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        Schema::create('recipes', function (Blueprint $table) {
            $table->id("recipes_id")->primary();
            $table->string('recipes_title_km');
            $table->string('recipes_title_en');
            $table->text('recipes_description_km');
            $table->text('recipes_description_en');
            $table->text('recipes_image_url')->nullable();
            $table->string('recipes_video_url')->nullable();
            $table->boolean('is_breakfast')->default(false);
            $table->string('recipes_created_by')->nullable();
            $table->bigInteger('recipes_view_counts')->default(0);
            $table->string('recipes_duration')->default(0);
            $table->foreignId('recipe_categories_id')
                ->constrained('recipe_categories', 'recipe_categories_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_categories');
        Schema::dropIfExists('recipes');
    }
};
