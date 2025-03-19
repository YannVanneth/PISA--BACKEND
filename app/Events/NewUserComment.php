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

class NewUserComment implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;

    /**
     * Create a new event instance.
     */
    public function __construct(UserCommentModel $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('user-comments.' . $this->comment->recipe_id),
        ];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'comment' => [
                'id' => $this->comment->users_comment_id,
                'content' => $this->comment->comment_content,
                'created_at' => $this->comment->created_at,
                'user' => [
                    'id' => $this->comment->profile->user_profile_id,
                    'name' => $this->comment->profile->first_name . ' ' . $this->comment->profile->last_name,
                    'avatar' => $this->comment->profile->imageURL,
                ],
            ],
        ];
    }
} 