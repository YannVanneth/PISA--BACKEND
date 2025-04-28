<?php

namespace App\Models\Recipes;

use App\Models\User\UserProfileModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecipeRatingModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'recipes_rating';

    protected $primaryKey = 'recipes_rating_id';

    protected $fillable = [
        'recipes_id',
        'profile_id',
        'rating_value',
    ];

    public function profile() : BelongsTo
    {
        return $this->belongsTo(UserProfileModel::class, 'profile_id', 'user_profile_id');
    }

    public function recipes() : BelongsTo
    {
        return $this->belongsTo(RecipeModel::class, 'recipes_id', 'recipes_id');
    }
}
