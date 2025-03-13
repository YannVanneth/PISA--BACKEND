<?php

namespace Database\Seeders;

use App\Models\Ingredients\IngredientModel;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    public function run()
    {
        IngredientModel::factory()->count(30)->create();
    }
}
