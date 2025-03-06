<?php

namespace Database\Seeders;

use App\Models\RecipesModel;
use Illuminate\Database\Seeder;

class RecipesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RecipesModel::factory()->count(50)->create();
    }
}
