<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class profile extends Model
{
    protected $fillable = [
        'first_name', 
        'last_name', 
        'picture', 
        'email', 
        'phone', 
        'is_verify', 
        'otp_code', 
        'otp_expires_at'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function socialLogins()
    {
        return $this->hasMany(SocialLogin::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
