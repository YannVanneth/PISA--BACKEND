<?php

namespace Database\Seeders;

use App\Models\Recipes\RecipeCategory;
use App\Models\Recipes\RecipeCategoryModel;
use Illuminate\Database\Seeder;

class RecipeCategorySeeder extends Seeder
{
    public function run()
    {
        RecipeCategoryModel::factory()->count(5)->create();
    }
}
