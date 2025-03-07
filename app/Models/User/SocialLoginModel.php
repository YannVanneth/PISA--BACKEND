<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLoginModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'social_login_id';

    protected $fillable = [
        'social_login_provider',
        'social_login_provider_id',
        'profile_id',
        'access_token',
    ];

    public function profile()
    {
        return $this->belongsTo(UserProfileModel::class, 'profile_id', 'user_profile_id');
    }
}
