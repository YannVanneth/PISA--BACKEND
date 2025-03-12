<?php

namespace App\Models\User;

use App\Models\Recipes\RecipeFavoriteModel;
use App\Models\Recipes\RecipeRatingModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfileModel extends Model
{
    use HasFactory;


    protected $table = 'user_profile';

    protected $primaryKey = 'user_profile_id';

    protected $fillable = [
            'first_name',
            'last_name',
            'imageURL',
            'email',
            'phone_number',
            'is_verified',
            'otp_code',
            'otp_code_expire_at',
    ];

    public function user()
    {
    return $this->hasOne(UserModel::class, 'profile_id', 'user_profile_id');
    }

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
}
