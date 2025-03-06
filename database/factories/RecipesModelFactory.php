<?php

namespace Database\Factories;

use App\Models\RecipesModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RecipesModelFactory extends Factory
{
    protected $model = RecipesModel::class;
    public function definition(): array
    {
        return [
            'recipes_title_km' => $this->faker->name(),
            'recipes_title_en' => $this->faker->name(),
            'recipes_description_km' => $this->faker->text(),
            'recipes_description_en' => $this->faker->text(),
            'recipes_imageURL' => $this->faker->imageUrl(),
            'recipes_videoURL' => $this->faker->url(),
            'recipes_created_by' => $this->faker->userName(),
            'recipes_view_counts' => $this->faker->numberBetween(0, 1000),
            'recipes_duration' => $this->faker->time(),
            'recipe_categories_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
