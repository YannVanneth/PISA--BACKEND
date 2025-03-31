<?php

namespace App\Events;

use App\Models\User\UserCommentModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentPosted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $recipeId;
    public $profileId;
    public $reactCount;
    public $commentContent;
    public $parentCommentId;
    public $isVerified;
    public $isLiked;
    public $replies;


    public function __construct($recipeId, UserCommentModel $comment)
    {
        $this->recipeId = $recipeId;
        $this->profileId = $comment->profile_id;
        $this->reactCount = $comment->react_count;
        $this->commentContent = $comment->comment_content;
        $this->parentCommentId = $comment->parent_comment_id;
        $this->isVerified = $comment->is_verified;
        $this->isLiked = $comment->is_liked;
        $this->replies = $comment->replies;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel('comment.'.$this->recipeId);
    }

    public function broadcastWith(): array
    {
        return [
            'recipe_id' => $this->recipeId,
            'profile_id' => $this->profileId,
            'react_count' => $this->reactCount,
            'comment_content' => $this->commentContent,
            'parent_comment_id' => $this->parentCommentId,
            'is_verified' => $this->isVerified,
            'is_liked' => $this->isLiked,
            'replies' => $this->replies,
        ];

    }

    public function broadcastAs(): string
    {
        return 'comment.posted';
    }
}
