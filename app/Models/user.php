<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user extends Model
{
    protected $fillable = ['username', 'password', 'profile_id'];
    protected $hidden = ['password'];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
