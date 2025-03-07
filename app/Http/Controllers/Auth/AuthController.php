<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Models\User\UserProfileModel;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request)
    {
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
            'is_verified' => false, // Default to false, verify via OTP later
        ]);

        // Create user
        $user = User::create([
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

        // Send OTP to email (you can use Laravel Mail or a package like Twilio)

        return response()->json([
            'message' => 'User registered successfully. Please verify your email.',
            'user' => $user,
        ], 201);
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
                'user' => $user,
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

    // Redirect to Google for authentication
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google callback
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        // Check if the user already exists
        $user = User::where('email', $googleUser->email)->first();

        if (!$user) {
            // Create a new user
            $userProfile = UserProfileModel::create([
                'first_name' => $googleUser->user['given_name'],
                'last_name' => $googleUser->user['family_name'],
                'email' => $googleUser->email,
                'is_verified' => true,
            ]);

            $user = User::create([
                'username' => $googleUser->email,
                'password' => Hash::make(Str::random(16)),
                'profile_id' => $userProfile->user_profile_id,
            ]);
        }

        // Log the user in
        Auth::login($user);
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Login with Google successful',
            'user' => $user,
            'token' => $token,
        ]);
    }

    // Redirect to Facebook for authentication
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Handle Facebook callback
    public function handleFacebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->user();

        // Check if the user already exists
        $user = User::where('email', $facebookUser->email)->first();

        if (!$user) {
            // Create a new user
            $userProfile = UserProfileModel::create([
                'first_name' => $facebookUser->user['first_name'],
                'last_name' => $facebookUser->user['last_name'],
                'email' => $facebookUser->email,
                'is_verified' => true,
            ]);

            $user = User::create([
                'username' => $facebookUser->email,
                'password' => Hash::make(Str::random(16)),
                'profile_id' => $userProfile->user_profile_id,
            ]);
        }

        // Log the user in
        Auth::login($user);
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Login with Facebook successful',
            'user' => $user,
            'token' => $token,
        ]);
    }
}
