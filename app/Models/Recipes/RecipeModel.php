<?php

namespace App\Models\Recipes;

use App\Models\CookingInstruction\CookingInstructionModel;
use App\Models\CookingInstruction\CookingStepModel;
use App\Models\Ingredients\IngredientModel;
use App\Models\User\UserCommentModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'recipes_id';

    protected $table = 'recipes';

    protected $fillable = [
        'recipes_id',
        'recipes_title_km',
        'recipes_title_en',
        'recipes_description_km',
        'recipes_description_en',
        'recipes_image_url',
        'recipes_video_url',
        'is_breakfast',
        'recipes_created_by',
        'recipes_view_counts',
        'recipes_duration',
        'recipe_categories_id',
        'is_breakfast',
    ];

    public function category()
    {
        return $this->belongsTo(RecipeCategoryModel::class, 'recipe_categories_id', 'recipe_categories_id');
    }

    public function cookingInstructions()
    {
        return $this->hasMany(CookingInstructionModel::class, 'recipes_id', 'recipes_id');
    }

    public function cookingSteps()
    {
        return $this->hasMany(CookingStepModel::class, 'recipes_id', 'recipes_id');
    }

    public function ingredients()
    {
        return $this->hasMany(IngredientModel::class, 'recipes_id', 'recipes_id');
    }
    public function favorites()
    {
        return $this->hasMany(RecipeFavoriteModel::class, 'recipes_id', 'recipes_id');
    }

    public function comments()
    {
        return $this->hasMany(UserCommentModel::class, 'recipes_id', 'recipes_id');
    }

}
