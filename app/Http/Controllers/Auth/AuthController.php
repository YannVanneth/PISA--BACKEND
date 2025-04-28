<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User\SocialLoginModel;
use App\Models\User\UserModel;
use App\Models\User\UserProfileModel;
use App\Notifications\UserNotification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function cancelRegistration(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string',
            ]);

            $email = $request->input('email');

            DB::transaction(function () use ($email) {

                DB::table('user_profile')
                    ->where('email', $email)
                    ->where('is_verified', 0)
                    ->delete();
            });

            return response()->json(['message' => 'Registration canceled.', 'isCanceled' => true]);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    // Register a new user
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'user_profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // check existing user
        if($this->checkExistingUser($request)){
            return response()->json(['message' => 'User already exists', 'is_available' => false], 200);
        };

        DB::beginTransaction();

        $imageURL = null;
        if($request->hasFile('user_profile_image')) {
            $image = $request->file('user_profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $imageURL = url('images/' . $imageName);
        }
        // Create user profile
        $userProfile = UserProfileModel::updateOrCreate(
            [
                'email' => $request->email,
            ]
            ,[
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'image_url' => $imageURL,
                'email' => $request->email,
                'is_verified' => false,
                'password' => Hash::make($request->password),
                'otp_code' => $this->requestOTPCode(),
                'otp_code_expire_at' => now()->addMinutes(10),
        ]);

        $token = $userProfile->createToken('auth_token')->plainTextToken;

        DB::commit();

        return response()->json([
            'message' => 'User registered successfully. Please verify your email.',
            'token' => $token,
            'user_profile' => $userProfile,
            'is_available' => true,
            'token_type' => 'Bearer',
        ], 200);
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    // Login a user
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'message' => 'Login successful',
                    'token' => $token,
                    'user_profile_id' => $user->user_profile_id,
                ]);
            }

            return response()->json(['message' => 'Invalid credentials'], 401);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
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

        // Validate the access token and id token
        if (!$accessToken) {
            return response()->json(['error' => 'Access token is required'], 400);
        }

        if (!$idToken) {
            return response()->json(['error' => 'ID token is required'], 400);
        }

        try {
            $tokenInfo = Http::withOptions(['verify' => Storage::path('cacert.pem')])->get(
                'https://oauth2.googleapis.com/tokeninfo?id_token=' . $idToken
            );

            if ($tokenInfo->getStatusCode() !== 200) {
                return response()->json([
                    'error' => 'Invalid ID token',
                ], 401);
            }

            $user = UserProfileModel::where('email', $tokenInfo->json('email'))
                ->where('provider', 'google')
                ->first();

            if ($user) {

                SocialLoginModel::updateOrCreate(
                    ['social_login_provider_id' => $tokenInfo->json('sub'), 'social_login_provider' => 'google'],
                    ['access_token' => $accessToken]
                );

                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'message' => 'Login successful',
                    'token' => $token,
                    'user_profile_id' => $user->user_profile_id,
                    'token_type' => 'Bearer'
                ], 200);
            }

            else {

             DB::beginTransaction();

            try {
                $userProfile = UserProfileModel::create([
                    'email' => $tokenInfo->json('email'),
                    'first_name' => $tokenInfo->json('given_name'),
                    'last_name' => $tokenInfo->json('family_name'),
                    'image_url' => $tokenInfo->json('picture'),
                    'provider' => 'google',
                    'password' => Hash::make($tokenInfo->json('sub')),
                    'is_verified' => true,
                ]);

                SocialLoginModel::create([
                    'social_login_provider_id' => $tokenInfo->json('sub'),
                    'social_login_provider' => 'google',
                    'profile_id' => $userProfile->user_profile_id,
                    'access_token' => $accessToken,
                ]);

                DB::commit();

                $token = $userProfile->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'message' => 'Login with Google successful',
                    'token' => $token,
                    'user_profile_id' => $userProfile->user_profile_id,
                    'token_type' => 'bearer'
                ], 200);

                } catch (\Exception $exception) {
                    DB::rollBack();
                    return response()->json(['error' => $exception->getMessage()], 500);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }

    // Handle Facebook callback
    public function handleFacebookCallback(Request $request)
    {
        $accessToken = $request->input('access_token');

        try {
            $tokenInfo = Http::withOptions([
                'verify' => Storage::path('cacert.pem'),
            ])->get('https://graph.facebook.com/me?fields=id,name,email,picture&access_token=' . $accessToken);

            if ($tokenInfo->getStatusCode() !== 200) {
                return response()->json(['error' => 'Invalid access token'], 401);
            }

            $user = UserProfileModel::where('email', $tokenInfo->json('email'))
                ->where('provider', 'facebook')
                ->first();

            if ($user) {
                SocialLoginModel::create([
                    'social_login_provider_id' => $tokenInfo->json('id'),
                    'social_login_provider' => 'facebook',
                    'access_token' => $accessToken,
                    'profile_id' => $user->user_profile_id,
                ]);

                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'user_profile_id' => $user->user_profile_id,
                    'message' => 'Login with Facebook successful',
                    'token' => $token,
                    'token_type' => 'bearer'
                ], 200);

            } else {
                try {
                    DB::beginTransaction();

                    $fullName = explode(' ', $tokenInfo->json('name'));
                    $firstName = $fullName[0] ?? '';
                    $lastName = $fullName[1] ?? '';

                    $picture = $tokenInfo->json('picture')['data']['url'] ?? null;

                    $userProfile = UserProfileModel::create([
                        'email' => $tokenInfo->json('email'),
                        'provider' => 'facebook',
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'image_url' => $picture,
                        'phone_number' => null,
                        'password' => Hash::make($tokenInfo->json('id')),
                        'is_verified' => true,
                        'otp_code' => null,
                        'otp_code_expire_at' => null,
                    ]);

                    SocialLoginModel::create([
                        'social_login_provider_id' => $tokenInfo->json('id'),
                        'social_login_provider' => 'facebook',
                        'access_token' => $accessToken,
                        'profile_id' => $userProfile->user_profile_id,
                    ]);

                    DB::commit();

                    $token = $userProfile->createToken('auth_token')->plainTextToken;

                    return response()->json([
                        'user_profile_id' => $userProfile->user_profile_id,
                        'message' => 'Login with Facebook successful',
                        'token' => $token,
                        'token_type' => 'Bearer'
                    ], 200);

                } catch (\Exception $exception) {
                    DB::rollBack();
                    return response()->json(['error' => $exception->getMessage()], 500);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }


    # Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout successful'], 200);
    }

    public function requestOTPCode() : int
    {
        return rand(1000, 9999);
    }

    private function checkExistingUser(Request $request)
    {
        return UserProfileModel::where('email', $request->email)->exists();
    }

    public function check()
    {
        return response()->json([
            'authenticated' => Auth::check(),
            'user' => Auth::check() ? Auth::user() : null,
        ]);
    }

    public function broadcastAuth(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['message' => 'Authenticated for broadcasting']);
    }
}
