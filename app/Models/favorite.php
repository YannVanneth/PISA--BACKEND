<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class favorite extends Model
{
    protected $fillable = ['recipe_id', 'profile_id'];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
