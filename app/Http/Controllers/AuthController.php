<?php

namespace App\Http\Controllers;
use App\Models\SocialLogin;
use App\Models\UserModel;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function googleAuth() : void{

        $googleUser = Socialite::driver('google')->user();

        $user = UserModel::query()->updateOrCreate([
            'email' => $googleUser->getEmail(),
        ], [
            'name' => $googleUser->getName(),
        ]);

        SocialLogin::query()->updateOrCreate([
            'user_id' => $user->id,
            'provider' => 'google',
            'provider_id' => $googleUser->getId(),
        ], [
            'access_token' => $googleUser->token,
        ]);

        Auth::login($user);
    }

    public function facebookAuth() : void{
        $user = Socialite::driver('google')->stateless()->user();
        $token = $user->token;
        $refreshToken = $user->refreshToken;
        $expiresIn = $user->expiresIn;
    }
}
