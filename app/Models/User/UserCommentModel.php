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
        'recipes_id',
        'profile_id',
        'react_count',
        'comment_content',
        'parent_comment_id',
        'is_verified',
        'is_liked',
        'replies',
    ];

    public function profile(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UserProfileModel::class, 'profile_id', 'user_profile_id');
    }

    public function recipe(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(RecipeModel::class, 'recipes_id', 'recipes_id');
    }
}
