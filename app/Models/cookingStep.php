<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cookingStep extends Model
{
    protected $fillable = [
        'recipe_id', 
        'step_number', 
        'instruction_kh', 
        'instruction_en'
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}
