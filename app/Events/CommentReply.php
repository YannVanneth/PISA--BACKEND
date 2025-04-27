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
    public UserProfileModel $replyTo;
    public UserCommentModel $replyComment;

    public function __construct(UserCommentModel $replyTo, UserCommentModel $replyComment)
    {
        $this->$replyTo = $replyTo;
        $this->$replyComment = $replyComment;
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
            new Channel('pisa-users.' . $this->replyTo->user_profile_id),
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
        return [
            'title' => $this->notification->title,
            'message' => $this->notification->body,
            'date' => $this->notification->created_at->format('d M Y'),
            'time' => $this->notification->created_at->format('H:i A'),
            'is_read' => $this->notification->is_read,
            'type' => $this->notification->type,
        ];
    }

    public function broadcastWhen(): bool
    {
        # check if the user is not the same as the one who replied
        return $this->replyTo->user_profile_id !== $this->replyComment->profile_id;
    }
}
