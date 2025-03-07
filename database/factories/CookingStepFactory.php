<?php

namespace Database\Factories;

use App\Models\CookingInstruction\CookingStepModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class CookingStepFactory extends Factory
{
    protected $model = CookingStepModel::class;

    public function definition()
    {
        return [
            'recipes_id' => \App\Models\RecipesModel::factory(),
            'steps_number' => $this->faker->numberBetween(1, 10),
            'cooking_instruction_en' => $this->faker->sentence,
            'cooking_instruction_km' => $this->faker->sentence,
        ];
    }
}
