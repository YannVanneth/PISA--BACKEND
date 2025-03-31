<?php

namespace App\Notifications;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentReply extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $profileId;
    public $replyContent;
    public $parentCommentId;

    public function __construct($profileId, $replyContent, $parentCommentId)
    {
        $this->profileId = $profileId;
        $this->replyContent = $replyContent;
        $this->parentCommentId = $parentCommentId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'profile_id' => $this->profileId,
            'reply_content' => $this->replyContent,
            'parent_comment_id' => $this->parentCommentId,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'data' => [
                'title' => 'Comment Reply',
                'message' => 'You have a new reply to your comment',
                'type' => 'comment_reply',
                'date' => now()->format('Y-m-d'),
                'time' => now()->format('H:i:s'),
                'un_read' => true,
            ],
        ]);
    }

    public function broadcastAs(): string
    {
        return 'comment.reply';
    }

    public function broadcastOn(): PrivateChannel
    {
       return new PrivateChannel('comment.user.'.$this->profileId);
    }
}
