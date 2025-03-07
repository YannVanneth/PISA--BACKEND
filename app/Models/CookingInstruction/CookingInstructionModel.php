<?php

namespace App\Models\CookingInstruction;

use App\Models\Recipes\RecipeModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CookingInstructionModel extends Model
{
    use HasFactory;

    protected $primaryKey = 'cooking_instructions_id';

    protected $fillable = [
        'recipes_id',
    ];

    public function recipe()
    {
        return $this->belongsTo(RecipeModel::class, 'recipes_id', 'recipes_id');
    }

    public function cookingSteps()
    {
        return $this->hasMany(CookingStepModel::class, 'recipes_id', 'recipes_id');
    }
}
