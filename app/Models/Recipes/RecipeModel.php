<?php

namespace App\Models\Recipes;

use App\Models\CookingInstruction\CookingInstructionModel;
use App\Models\CookingInstruction\CookingStepModel;
use App\Models\Ingredients\IngredientModel;
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
        'recipes_imageURL',
        'recipes_videoURL',
        'recipes_created_by',
        'recipes_view_counts',
        'recipes_duration',
        'recipe_categories_id',
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
}
