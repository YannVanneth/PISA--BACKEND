<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ingredient extends Model
{
    public $timestamps = true;   
    protected $fillable = [
        'recipe_id',
        'name_kh',
        'name_en',
        'quantity',
        'unit',
        'picture',
    ];

    public function recipe() {
        return $this->belongsTo(Recipe::class);
    }
}
