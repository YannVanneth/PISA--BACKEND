<?php

namespace App\Notifications;

use App\Models\NotificationModel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class UserNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    public string $title;
    public string $message;
    public string $type;
    public int $userId;
    public bool $unread = true;

    public function __construct(string $title, string $message, string $type, int $userId)
    {
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
        $this->userId = $userId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'description' => $this->message,
            'type' => $this->type,
            'date' => now()->format('Y-m-d'),
            'time' => now()->format('H:i:s'),
            'un_read' => $this->unread,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        NotificationModel::create(
            [
                'title' => $this->title,
                'message' => $this->message,
                'type' => $this->type,
                'is_global' => 0,
                'expires_at' => now()->addDays(7),
            ]
        );

       return new BroadcastMessage(
              [
                'title' => $this->title,
                'message' => $this->message . $notifiable->name,
                'type' => $this->type,
                'date' => now()->format('Y-m-d'),
                'time' => now()->format('H:i:s'),
                'un_read' => $this->unread,
              ]
       );
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('user.' . auth()->id());
    }

    public function broadcastType(): string
    {
        return 'private.user';
    }

    public function broadcastAs(): string
    {
        return 'user-notification';
    }
}
