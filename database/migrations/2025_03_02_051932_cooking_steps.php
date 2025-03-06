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
        if (Schema::hasTable('recipes')) {
            Schema::create('cooking_steps', function (Blueprint $table) {
                $table->id('cooking_steps_id')->primary();
                $table->foreignId('recipes_id')
                    ->constrained('recipes', 'recipes_id');
                $table->integer('steps_number');
                $table->text('cooking_instruction_en');
                $table->text('cooking_instruction_km');
                $table->timestamps();
            });
        }
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cooking_steps');
    }
};
