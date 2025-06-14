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
        if(Schema::hasTable('recipes')){
            Schema::create('ingredients', function (Blueprint $table) {
                $table->id('ingredients_id');
                $table->foreignId('recipes_id')
                    ->constrained('recipes', 'recipes_id');
                $table->string('ingredients_name_en');
                $table->string('ingredients_name_km');
                $table->string('ingredients_quantity');
                $table->string('ingredients_unit_en');
                $table->string('ingredients_unit_km');
                $table->string('ingredients_image_url');
                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('ingredients');
    }
};
