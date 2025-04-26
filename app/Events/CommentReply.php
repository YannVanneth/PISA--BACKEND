<?php

namespace App\Events;

use App\Models\User\UserCommentModel;
use App\Models\User\UserProfileModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentReply
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public UserProfileModel $user;
    public UserCommentModel $replyComment;
    public UserCommentModel $parentComment;

    public function __construct(UserProfileModel $user, UserCommentModel $replyTo, UserCommentModel $parentComment)
    {
        $this->user = $user;
        $this->replyComment = $replyTo;
        $this->parentComment = $parentComment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        # broadcast to the user who is being replied to
        return [
            new Channel('user.' .$this->user->user_profile_id),
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */

    public function broadcastAs(): string
    {
        return 'comment.reply';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */

    public function broadcastWith(): array
    {
        # return with user comment data
        return [
            'user' => $this->user,
            'replyComment' => $this->replyComment,
            'parentComment' => $this->parentComment,
        ];
    }

    public function broadcastWhen(): bool
    {
        # check if the user is not the same as the one who replied
        return $this->user->user_profile_id !== $this->replyComment->profile_id;
    }
}
