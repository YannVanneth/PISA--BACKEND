<?php

namespace Database\Seeders;

use App\Models\Recipes\RecipeCategoryModel;
use Illuminate\Database\Seeder;

class RecipeCategoryModelSeeder extends Seeder
{
    public function run()
    {
        RecipeCategoryModel::factory()->count(5)->create();
    }
}
