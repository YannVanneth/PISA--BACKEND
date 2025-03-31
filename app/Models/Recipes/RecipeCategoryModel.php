<?php

namespace App\Models\Recipes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeCategoryModel extends Model
{
    use HasFactory;

    protected $table = 'recipe_categories';

    protected $primaryKey = 'recipe_categories_id';

    protected $fillable = [
        'recipe_categories_km',
        'recipe_categories_en',
        'image_url',
    ];

    public function recipes()
    {
        return $this->hasMany(RecipeModel::class, 'recipe_categories_id', 'recipe_categories_id');
    }


}
