<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User\SocialLoginModel;
use App\Models\User\UserProfileModel;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Http;
class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
        $request->validate([
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:user_profile,email',
            'password' => 'required|string|min:8',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ]);

        // Create user profile
        $userProfile = UserProfileModel::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'is_verified' => false,
        ]);

        // Create user
        $user = UserModel::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'profile_id' => $userProfile->user_profile_id,
        ]);

        // Generate OTP (for email verification)
        $otp = rand(100000, 999999);
        $userProfile->update([
            'otp_code' => $otp,
            'otp_code_expire_at' => now()->addMinutes(30),
        ]);


        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully. Please verify your email.',
            'user' => $user,
            'token' => $token,
            'token_type' => 'bearer',
        ], 201);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    // Login a user
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
            ]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // Forgot password
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Reset link sent to your email'], 200)
            : response()->json(['message' => 'Unable to send reset link'], 400);
    }

    // Reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password reset successfully'], 200)
            : response()->json(['message' => 'Unable to reset password'], 400);
    }

    public function handleGoogleCallback(Request $request)
    {
        $accessToken = $request->input('access_token');
        $idToken = $request->input('id_token');

        if (!$accessToken) {
            return response()->json(['error' => 'Access token is required'], 400);
        }

        try {
            $tokenInfo = Http::withOptions(
                ['verify' => false,]
            )->get(
                'https://oauth2.googleapis.com/tokeninfo?id_token=' . $idToken);

            if ($tokenInfo->getStatusCode() == 200) {
                if($this->SaveToDatabase($tokenInfo, $accessToken, 'google')){
                    return response()->json([
                        'message' => 'Login with Google successful',
                        'token_info' => $tokenInfo->getBody()->getContents(),
                        'access_token' => $accessToken,
                        'id_token' => $idToken,
                    ]);
                }else{
                    return response()->json([
                        'message' => 'insert data to database failed',
                    ]);
                }
            }

            return response()->json([
               'message' => 'Login with Google failed',
            ]);


        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
    // Handle Facebook callback
    public function handleFacebookCallback(Request $request)
    {
        $accessToken = $request->input('access_token');

       try{


           $tokenInfo = Http::withOptions(
               ['verify' => false,]
           )->get('https://graph.facebook.com/me?fields=id,name,email,picture&access_token=' . $accessToken);

           return response()->json(['data' => $tokenInfo->getBody()->getContents()], 401);

       }catch (\Exception $e){
           return response()->json(['error' => $e->getMessage()], 401);
       }
    }

    private function SaveToDatabase($tokenInfo, $accessToken, $provider) : bool
    {
        try{
            $userProfile = UserProfileModel::updateOrCreate(
                [
                    'email' => $tokenInfo->json('email'),
                ],
                [
                    'first_name' => $tokenInfo->json('given_name'),
                    'last_name' => $tokenInfo->json('family_name'),
                    'imageURL' => $tokenInfo->json('picture'),
                    'email' => $tokenInfo->json('email'),
                    'phone_number' => null,
                    'is_verified' => false,
                    'otp_code' => null,
                    'otp_code_expire_at' => null,
                ]
            );

            SocialLoginModel::updateOrCreate(
                [
                    'profile_id' => $userProfile->user_profile_id
                ],
                [
                    'social_login_provider' => $provider,
                    'social_login_provider_id' => rand(1000, 9999),
                    'access_token' => $accessToken,
                ]
            );

            return true;
        }catch (\Exception $exception){
            return false;
        }
    }
}
