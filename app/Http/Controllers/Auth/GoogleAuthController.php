<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialLoginModel;
use App\Models\UserModel;
use App\Models\UserProfileModel;
use Google\Service\Classroom\UserProfile;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class oogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return response()->json([
            'url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl()
        ]);
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            if (!$googleUser) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve user from Google.'
                ], 401);
            }

            // Debugging: Log user details
            \Log::info('Google User:', (array) $googleUser);

            // Check if user exists
            $user = UserProfileModel::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Create user profile
                $user = UserProfileModel::create([
                    'first_name' => $googleUser->user['given_name'] ?? '',
                    'last_name' => $googleUser->user['family_name'] ?? '',
                    'imageURL' => $googleUser->getAvatar(),
                    'email' => $googleUser->getEmail(),
                    'phone_number' => $googleUser->user['phone_number'] ?? null, // Google may not provide a phone number
                ]);

                // Create social login record
                SocialLoginModel::create([
                    'user_profile_id' => $user->id, // Ensure foreign key is set
                    'social_login_provider' => 'google',
                    'social_login_provider_id' => $googleUser->getId(),
                    'access_token' => $googleUser->token,
                ]);
            }

            // Generate JWT Token
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Google Authentication Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Authentication failed!',
                'error' => $e->getMessage()
            ], 401);
        }
    }

}

