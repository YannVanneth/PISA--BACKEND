<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipesModel extends Model
{
    use HasFactory;

    protected $table = 'recipes';
    protected $primaryKey = 'recipes_id';
    protected $fillable = [
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
}
