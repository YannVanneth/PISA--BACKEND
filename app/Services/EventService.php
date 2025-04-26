<?php

namespace App\Services;

use App\Events\UserNotifications;
use App\Models\NotificationModel;
use App\Models\User\UserCommentModel;

class EventService{
    public static function sendNotification($notification): void
    {
        // save to database
        NotificationModel::create([
            'title' => $notification['title'],
            'body' => $notification['body'],
            'type' => $notification['type'] ?? null,
            'user_id' => $notification['user_id'] ?? 1,
        ]);

        // Send notification to the user
        event(new UserNotifications($notification));
    }

    public static function sendCommentReplyNotification($notification): void
    {
        // save to database
        NotificationModel::create([
            'title' => $notification['title'],
            'body' => $notification['body'],
            'type' => $notification['type'] ?? null,
            'user_id' => $notification['user_id'] ?? 1,
        ]);

        // Send notification to the user
        event(new UserNotifications($notification));
    }

    public static function PostComment($comment) : void
    {
        // save to database
        UserCommentModel::updateOrCreate([
            'recipe_id' => $comment['recipe_id'],
            'user_profile_id' => $comment['user_profile_id'],
            'comment' => $comment['comment'],
        ]);

    }
}
