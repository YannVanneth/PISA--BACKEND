<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RecipeCategoryModelSeeder::class,
            RecipeSeeder::class,
            IngredientSeeder::class,
            CookingInstructionSeeder::class,
            CookingStepSeeder::class,
        ]);
    }
}
