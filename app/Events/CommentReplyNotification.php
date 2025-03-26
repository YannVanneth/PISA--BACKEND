<?php

namespace App\Events;

use App\Models\Recipes\RecipeCommentModel;
use App\Models\User\UserProfileModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentReplyNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public RecipeCommentModel $comment;
    public UserProfileModel $repliedToUser;

    public function __construct(RecipeCommentModel $comment, UserProfileModel $repliedToUser)
    {
        $this->comment = $comment;
        $this->repliedToUser = $repliedToUser;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->repliedToUser->user_profile_id),
            new Channel('recipe-comments.' . $this->comment->recipes_id)
        ];
    }

    public function broadcastAs(): string
    {
        return 'comment-reply';
    }
} 