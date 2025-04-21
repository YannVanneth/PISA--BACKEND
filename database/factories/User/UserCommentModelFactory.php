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
            'content' => $this->faker->sentence,
            'parent_comment_id' => UserCommentModel::factory(),
            'is_verified' => $this->faker->boolean,
        ];
    }
}
