<?php

namespace Database\Factories;

use App\Models\RecipeCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeCategoryFactory extends Factory
{
    protected $model = RecipeCategory::class;

    public function definition(): array
    {
        return [
            'recipe_categories_km' => $this->faker->name(),
            'recipe_categories_en' => $this->faker->name(),
            'imageURl' => $this->faker->imageUrl(),
        ];
    }
}
