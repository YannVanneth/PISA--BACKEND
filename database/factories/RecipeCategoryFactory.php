<?php

namespace Database\Factories;

use App\Models\Recipes\RecipeCategoryModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeCategoryFactory extends Factory
{
    protected $model = RecipeCategoryModel::class;

    public function definition()
    {
        return [
            'recipe_categories_km' => $this->faker->word,
            'recipe_categories_en' => $this->faker->word,
            'imageURl' => $this->faker->imageUrl(),
        ];
    }
}
