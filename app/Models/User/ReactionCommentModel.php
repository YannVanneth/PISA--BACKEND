<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReactionCommentModel extends Model
{
    use HasFactory;

    protected $table = 'user_reacted_comments';

    protected $fillable = [
        'comment_id',
        'profile_id',
        'reaction'
    ];

    public function comment()
    {
        return $this->belongsTo(UserCommentModel::class, 'comment_id', 'users_comment_id');
    }

    public function profile()
    {
        return $this->belongsTo(UserProfileModel::class, 'profile_id', 'user_profile_id');
    }
}
