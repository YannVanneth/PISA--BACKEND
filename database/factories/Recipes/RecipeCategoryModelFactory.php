<?php

namespace Database\Factories\Recipes;

use App\Models\Recipes\RecipeCategoryModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeCategoryModelFactory extends Factory
{
    protected $model = RecipeCategoryModel::class;

    public function definition()
    {
        return [
            'recipe_categories_km' => $this->faker->name,
            'recipe_categories_en' => $this->faker->name,
            'imageURl' => $this->faker->imageUrl(),
        ];
    }
}
