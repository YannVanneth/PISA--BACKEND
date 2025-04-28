<?php

namespace App\Models\User;

use App\Models\Recipes\RecipeModel;
use Illuminate\Database\Eloquent\Model;

class UserViewRecipe extends Model
{
    protected $table = 'user_view_recipe';

    protected $primaryKey = 'user_view_recipe_id';

    protected $fillable = [
        'user_profile_id',
        'recipe_id',
    ];

    public function user()
    {
        return $this->belongsTo(UserProfileModel::class, 'user_profile_id', 'user_profile_id');
    }

    public function recipe()
    {
        return $this->belongsTo(RecipeModel::class, 'recipe_id', 'recipe_id');
    }
}
