<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class CommentReactionModel extends Model
{
    protected $table = 'comment_reactions';

    protected $primaryKey = 'comment_reactions_id';

    protected $fillable = [
        'user_id',
        'comment_id',
        'is_liked',
    ];

    public function user()
    {
        return $this->belongsTo(UserProfileModel::class, 'user_id', 'user_profile_id');
    }

    public function comment()
    {
        return $this->belongsTo(UserCommentModel::class, 'comment_id', 'users_comment_id');
    }
}
