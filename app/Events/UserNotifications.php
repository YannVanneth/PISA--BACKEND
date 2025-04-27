<?php

namespace App\Events;

use App\Models\NotificationModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserNotifications implements ShouldBroadcast , ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public NotificationModel $notification;
    public String $channel;
    public String $eventName;
    public function __construct(NotificationModel $notification, String $channel = 'pisa-users', String $eventName = 'user.notifications')
    {
        $this->notification = $notification;
        $this->channel = $channel;
        $this->eventName = $eventName;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel($this->channel),
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */

    public function broadcastAs(): string    {
        return $this->eventName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */

    public function broadcastWith(): array    {
        return [
            'id' => $this->notification->id,
            'title' => $this->notification->title,
            'message' => $this->notification->body,
            'date' => $this->notification->created_at->format('d M Y'),
            'time' => $this->notification->created_at->format('H:i A'),
            'is_read' => $this->notification->is_read,
            'type' => $this->notification->type,
        ];
    }

    public function dontBroadcastToCurrentUser(): bool
    {
        return true;
    }




}
