<?php

namespace App\Models\User;

use App\Models\NotificationModel;
use App\Models\Recipes\RecipeFavoriteModel;
use App\Models\Recipes\RecipeRatingModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserProfileModel extends Authenticatable
{
    use HasFactory, notifiable, hasApiTokens;

    protected $table = 'user_profile';

    protected $primaryKey = 'user_profile_id';

    protected $fillable = [
            'first_name',
            'last_name',
            'image_url',
            'email',
            'password',
            'provider',
            'phone_number',
            'is_verified',
            'otp_code',
            'otp_code_expire_at',
    ];
    protected $hidden = [
        'password',
    ]
;


    public function socialLogins()
    {
    return $this->hasMany(SocialLoginModel::class, 'profile_id', 'user_profile_id');
    }

    public function comments()
    {
    return $this->hasMany(UserCommentModel::class, 'profile_id', 'user_profile_id');
    }

    public function ratings()
    {
    return $this->hasMany(RecipeRatingModel::class, 'profile_id', 'user_profile_id');
    }

    public function favorites()
    {
    return $this->hasMany(RecipeFavoriteModel::class, 'profile_id', 'user_profile_id');
    }

    public function notifications()
    {
        return $this->hasMany(NotificationModel::class, 'user_id', 'user_profile_id');
    }
}
