<?php

namespace App\Models\Ingredients;

use App\Models\Recipes\RecipeModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'ingredients_id';

    protected $fillable = [
        'recipes_id',
        'ingredients_name_en',
        'ingredients_name_km',
        'ingredients_quantity',
        'ingredients_unit',
        'ingredients_imageURL',
    ];

    // Define the relationship with the Recipe model
    public function recipe()
    {
        return $this->belongsTo(RecipeModel::class, 'recipes_id', 'recipes_id');
    }
}
