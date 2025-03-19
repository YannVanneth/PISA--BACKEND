<?php

namespace App\Models\Recipes;

use App\Models\User\UserProfileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeCommentModel extends Model
{
    use HasFactory;

    protected $table = 'recipe_comments';

    protected $primaryKey = 'recipe_comments_id';

    protected $fillable = [
        'recipes_id',
        'profile_id',
        'comment_text',
    ];

    public function profile()
    {
        return $this->belongsTo(UserProfileModel::class, 'profile_id', 'user_profile_id');
    }

    public function recipe()
    {
        return $this->belongsTo(RecipeModel::class, 'recipes_id', 'recipes_id');
    }
} 