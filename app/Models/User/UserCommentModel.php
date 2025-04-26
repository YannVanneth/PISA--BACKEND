<?php

namespace App\Models\User;

use App\Models\Recipes\RecipeModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCommentModel extends Model
{
    use HasFactory;

    protected $table = 'user_comments';

    protected $primaryKey = 'users_comment_id';

    protected $fillable = [
        'recipe_id',
        'profile_id',
        'react_count',
        'content',
        'parent_comment_id',
        'is_verified',
        'created_at',
        'updated_at',
    ];

    public function profile(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UserProfileModel::class, 'profile_id', 'user_profile_id');
    }

    public function recipe(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(RecipeModel::class, 'recipes_id', 'recipe_id');
    }

    public function replies()
    {
        return $this->hasMany(UserCommentModel::class, 'parent_comment_id');
    }

    public function reactions()
    {
        return $this->hasMany(CommentReactionModel::class, 'comment_id', 'users_comment_id');
    }


    public function reactCount()
    {
        return $this->hasMany(CommentReactionModel::class, 'comment_id', 'users_comment_id')->count();
    }
}
