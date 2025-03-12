<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId("category_id");
            $table->string("title_kh");
            $table->string("title_en");
            $table->text("description_kh");
            $table->text("description_en");
            $table->string("picture")->nullable;
            $table->string("video")->nullable;
            $table->integer("view_count")->default(0); // Fixed from string to integer
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
