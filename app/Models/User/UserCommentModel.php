<?php

namespace App\Models\User;

use App\Models\Recipes\RecipeModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCommentModel extends Model
{
    use HasFactory;

    protected $table = 'users_comment';

    protected $primaryKey = 'users_comment_id';

    protected $fillable = [
        'recipe_id',
        'profile_id',
        'react_count',
        'comment_content',
        'parent_comment_id',
        'is_verified',
        'is_liked',
        'replies',
    ];

    public function profile()
    {
        return $this->belongsTo(UserProfileModel::class, 'profile_id', 'user_profile_id');
    }

    public function recipe()
    {
        return $this->belongsTo(RecipeModel::class, 'recipe_id', 'recipes_id');
    }
}
