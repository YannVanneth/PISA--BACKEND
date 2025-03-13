<?php

namespace Database\Factories;

use App\Models\CookingInstruction;
use Illuminate\Database\Eloquent\Factories\Factory;

class CookingInstructionFactory extends Factory
{
    protected $model = CookingInstruction\CookingInstructionModel::class;

    public function definition()
    {
        return [
            'recipes_id' => \App\Models\RecipesModel::factory(),
        ];
    }
}
