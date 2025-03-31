<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserActivity implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public string $title;
    public string $message;
    public string $type;
    public int $userId;
    public function __construct(string $title, string $message, string $type, int $userId)
    {
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return [
            new PrivateChannel('user' . $this->userId),
        ];
    }
}
