<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserModel extends Authenticatable
{
    use HasFactory,HasApiTokens, notifiable;

    protected $table = 'users';

    protected $primaryKey = 'users_id';

    protected $fillable = [
        'username',
        'password',
        'profile_id',
        'email'
    ];

    protected $hidden = [
        'password',
    ];

    public function profile()
    {
        return $this->belongsTo(UserProfileModel::class, 'profile_id', 'user_profile_id');
    }
}
