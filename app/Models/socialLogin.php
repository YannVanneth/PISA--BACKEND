<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class socialLogin extends Model
{
    protected $fillable = [
        'social', 'social_id', 'profile_id', 'access_token'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
