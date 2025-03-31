<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'notifications_id';
    protected $fillable = [
        'title',
        'message',
        'type',
        'is_global',
        'expires_at',
    ];

    public function userNotifications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserNotificationModel::class, 'notification_id', 'notifications_id');
    }
}
