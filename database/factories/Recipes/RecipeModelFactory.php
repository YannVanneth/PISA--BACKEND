<?php

namespace Database\Factories\Recipes;

use App\Models\Recipes\RecipeCategoryModel;
use App\Models\Recipes\RecipeModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeModelFactory extends Factory
{
    protected $model = RecipeModel::class;

    public function definition()
    {
        return [
            'recipes_title_km' => $this->faker->sentence,
            'recipes_title_en' => $this->faker->sentence,
            'recipes_description_km' => $this->faker->paragraph,
            'recipes_description_en' => $this->faker->paragraph,
            'recipes_imageURL' => $this->faker->imageUrl(),
            'recipes_videoURL' => $this->faker->url,
            'recipes_created_by' => $this->faker->name,
            'recipes_view_counts' => $this->faker->numberBetween(0, 1000),
            'recipes_duration' => $this->faker->time('H:i:s'),
            'recipe_categories_id' => RecipeCategoryModel::factory(),
        ];
    }
}
