<?php

namespace App\Models;

use App\Models\User\UserProfileModel;
use Illuminate\Database\Eloquent\Model;

class UserNotificationModel extends Model
{
    protected $table = 'user_notifications';
    protected $primaryKey = 'user_notifications_id';
    protected $fillable = [
        'user_profile_id',
        'notification_id',
        'is_read',
        'delivered_at',
        'read_at',
    ];

    public function userProfile(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UserProfileModel::class, 'user_profile_id', 'user_profile_id');
    }

    public function notification(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(NotificationModel::class, 'notification_id', 'notifications_id');
    }
}
