<?php

namespace App\Models\CookingInstruction;

use App\Models\Recipes\RecipeModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CookingStepModel extends Model
{
    use HasFactory;

    protected $table = 'cooking_steps';

    protected $primaryKey = 'cooking_steps_id';

    protected $fillable = [
        'recipes_id',
        'steps_number',
        'cooking_instruction_en',
        'cooking_instruction_km',
    ];

    public function recipe()
    {
        return $this->belongsTo(RecipeModel::class, 'recipes_id', 'recipes_id');
    }
}
