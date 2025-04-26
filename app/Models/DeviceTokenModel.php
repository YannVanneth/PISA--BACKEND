<?php

namespace App\Models;

use App\Models\User\UserProfileModel;
use Illuminate\Database\Eloquent\Model;

class DeviceTokenModel extends Model
{
    protected $table = 'device_token';

    protected $primaryKey = 'device_token_id';

    protected $fillable = [
        'device_token',
        'user_profile_id',
    ];

    public function user()
    {
        return $this->belongsTo(UserProfileModel::class, 'user_profile_id', 'user_profile_id');
    }
}
