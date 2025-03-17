<?php

namespace App\Models\WishList;

use App\Models\Recipes\RecipeModel;
use App\Models\User\UserModel;
use App\Models\User\UserProfileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishListModel extends Model
{
    use HasFactory;

    protected $table = 'wishlist';

    protected $primaryKey = 'wishlist_id';

    protected $fillable = [
        'recipe_id',
        'profile_id',
    ];

    public function profile()
    {
        return $this->belongsTo(UserProfileModel::class, 'profile_id', 'user_profile_id');
    }

    public function recipe()
    {
        return $this->belongsTo(RecipeModel::class, 'recipe_id', 'recipe_id');
    }
}
