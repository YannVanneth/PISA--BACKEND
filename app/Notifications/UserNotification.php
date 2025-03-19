<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class UserNotification extends Notification
{
    use Queueable;

    private $message;
    private $eventType;

    public function __construct($eventType, $message = null)
    {
        $this->eventType = $eventType;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['verifyOTPMail', 'database'];
    }

    public function toMail($notifiable)
    {
        $message = $this->getMessage();

        return (new MailMessage)
                    ->line($message)
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'message' => $this->getMessage(),
        ]);
    }

    private function getMessage()
    {
        switch ($this->eventType) {
            case 'login':
                return $this->message ?? 'You have successfully logged in.';
            case 'register':
                return $this->message ?? 'You have successfully registered.';
            case 'password_reset':
                return $this->message ?? 'Your password has been reset.';
            case 'change_password':
                return $this->message ?? 'Your password has been changed.';
            case 'reply-comment':
                return $this->message ?? 'You have a new reply to your comment.';
            case 'reaction-comment':
                return $this->message ?? 'Someone reacted to your comment.';
            default:
                return $this->message ?? 'You have a new notification.';
        }
    }
}
