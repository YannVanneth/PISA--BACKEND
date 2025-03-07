<?php

namespace Database\Factories;

use App\Models\Ingredients\IngredientModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{
    protected $model = IngredientModel::class;

    public function definition()
    {
        return [
            'recipes_id' => \App\Models\RecipesModel::factory(),
            'ingredients_name_en' => $this->faker->word,
            'ingredients_name_km' => $this->faker->word,
            'ingredients_quantity' => $this->faker->numberBetween(1, 10),
            'ingredients_unit' => $this->faker->word,
            'ingredients_imageURL' => $this->faker->imageUrl(),
        ];
    }
}
