<?php

namespace App\Models\Recipes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeCategory extends Model
{

    use HasFactory;

    protected $table = 'recipe_categories';

    protected $fillable = [
        'recipe_categories_id',
        'recipe_categories_km',
        'recipe_categories_en',
        'imageURl',
    ];
}
