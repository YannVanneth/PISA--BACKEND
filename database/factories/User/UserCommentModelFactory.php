<?php

namespace Database\Factories\User;

use App\Models\Recipes\RecipeModel;
use App\Models\User\UserCommentModel;
use App\Models\User\UserProfileModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserCommentModelFactory extends Factory{

    protected $model = UserCommentModel::class;
    public function definition()
    {
        return [
            'recipe_id' => RecipeModel::factory(),
            'profile_id' => UserProfileModel::factory(),
            'react_count' => $this->faker->randomDigit,
            'comment_content' => $this->faker->sentence,
            'parent_comment_id' => null,
            'is_verified' => $this->faker->boolean,
            'is_liked' => $this->faker->boolean,
            'replies' => $this->faker->sentence,
        ];
    }
}
