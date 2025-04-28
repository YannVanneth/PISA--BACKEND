<?php

namespace App\Events;

use App\Http\Resources\api\v1\UserCommentModelResource;
use App\Models\User\UserCommentModel;
use App\Models\User\UserProfileModel;
use DateTimeInterface;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentPost implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public $comment;
    public function __construct($comment)
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
            new Channel('recipe-post.' . $this->comment->recipe_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'comment.post';
    }

    public function broadcastWith(): array
    {
        $profile = $this->comment->profile;

        return [
            'users_comment_id' => $this->comment->users_comment_id,
            'recipes_id' => $this->comment->recipe_id,
            'profile_id' => [
                'user_profile_id' => $profile->user_profile_id,
                'first_name' => $profile->first_name,
                'last_name' => $profile->last_name,
                'image_url' => $profile->image_url,
                'email' => $profile->email,
                'phone_number' => $profile->phone_number,
                'is_verified' => (int) $profile->is_verified,
                'otp_code' => $profile->otp_code,
                'otp_code_expire_at' => $profile->otp_code_expire_at,
                'provider' => $profile->provider,
                'created_at' => $profile->created_at->toISOString(),
                'updated_at' => $profile->updated_at->toISOString(),
            ],
            'react_count' => $this->comment->react_count ?? 0,
            'is_verified' => $this->comment->is_verified,
            'replies' => $this->comment->replies ?? [],
            'contents' => $this->comment->content,
            'is_liked' => $this->comment->is_liked ?? false,
            'parent_comment_id' => $this->comment->parent_comment_id,
            'created_at' => $this->comment->created_at->format(DateTimeInterface::ISO8601),
            'updated_at' => $this->comment->updated_at->format(DateTimeInterface::ISO8601),
        ];
    }

    public function broadcastToEveryone()
    {
        return true;
    }

    public function dontBroadcastToCurrentUser(): bool
    {
        return true;
    }



}
