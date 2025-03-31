<?php

namespace App\Models\Ingredients;

use App\Models\Recipes\RecipeModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientModel extends Model
{
    use HasFactory;

    protected $table = 'ingredients';

    protected $primaryKey = 'ingredients_id';

    protected $fillable = [
        'recipes_id',
        'ingredients_name_en',
        'ingredients_name_km',
        'ingredients_quantity',
        'ingredients_unit_en',
        'ingredients_unit_km',
        'ingredients_image_url',
    ];

    // Define the relationship with the Recipe model
    public function recipe()
    {
        return $this->belongsTo(RecipeModel::class, 'recipes_id', 'recipes_id');
    }
}
