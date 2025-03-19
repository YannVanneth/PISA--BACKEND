<?php

namespace App\Events;

use App\Models\Recipes\RecipeCommentModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewRecipeComment implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;

    /**
     * Create a new event instance.
     */
    public function __construct(RecipeCommentModel $comment)
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
            new Channel('recipe-comments.' . $this->comment->recipes_id),
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
                'id' => $this->comment->recipe_comments_id,
                'text' => $this->comment->comment_text,
                'created_at' => $this->comment->created_at,
                'user' => [
                    'id' => $this->comment->profile->user_profile_id,
                    'name' => $this->comment->profile->user_name,
                    'avatar' => $this->comment->profile->user_avatar,
                ],
            ],
        ];
    }
} 