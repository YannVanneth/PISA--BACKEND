<?php

namespace Database\Seeders;

use App\Models\Recipes\RecipeModel;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function run()
    {
        RecipeModel::factory()->count(10)->create();
    }
}
