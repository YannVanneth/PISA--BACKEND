<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model
{

    protected $table = 'notifications';
    protected $primaryKey = 'notifications_id';
    protected $fillable = [
        'title',
        'body',
        'type',
        'is_read',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(UserProfileModel::class, 'user_id', 'user_profile_id');
    }
}
