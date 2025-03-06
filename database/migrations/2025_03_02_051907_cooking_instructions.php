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
        if(Schema::hasTable('recipes')) {
            Schema::create('cooking_instructions', function (Blueprint $table) {
                $table->id('cooking_instructions_id');
                $table->foreignId('recipes_id')
                    ->constrained('recipes', 'recipes_id');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cooking_instructions');
    }
};
