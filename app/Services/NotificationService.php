<?php

namespace App\Services;

use App\Events\UserNotifications;
use App\Models\NotificationModel;
use App\Models\User\UserCommentModel;

class NotificationService{
    public static function sendNotification($notification, String $channel = 'pisa-users', String $eventName = 'user.notifications'): void
    {
        event(new UserNotifications($notification, $channel, $eventName));
    }
}
