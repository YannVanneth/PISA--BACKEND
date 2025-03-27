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
class AuthController extends Controller
{
    public function cancelRegistration(Request $request)
    {
        try {

            $request->validate([
                'email' => 'required|email',
            ]);
            $email = $request->input('email');

            DB::transaction(function () use ($email) {
                DB::table('users')
                    ->whereIn('profile_id', function ($query) use ($email) {
                        $query->select('user_profile_id')
                            ->from('user_profile')
                            ->where('email', $email)
                            ->where('is_verified', 0);
                    })
                    ->delete();

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
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ]);

        // check existing user
        if($this->checkExistingUser($request)){
            return response()->json(['message' => 'User already exists', 'is_available' => false], 200);
        };

        // Create user profile
        $userProfile = UserProfileModel::updateOrCreate(
            [
                'email' => $request->email,
            ]
            ,[
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'is_verified' => false,
        ]);

        // Create user
        $user = UserModel::updateOrCreate([
            'username' => $request->username,
        ],[
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'profile_id' => $userProfile->user_profile_id,
        ]);

        // Generate OTP (for email verification)
        $otp = $this->requestOTPCode();
        $userProfile->update([
            'otp_code' => $otp,
            'otp_code_expire_at' => now()->addMinutes(10),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully. Please verify your email.',
            'user' => $user,
            'token' => $token,
            'is_available' => true,
            'token_type' => 'bearer',
        ], 200);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    // Login a user
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->validate([
                'email' => 'required_without:username|email',
                'username' => 'required_without:email|string',
                'password' => 'required|string',
            ]);

            $loginField = $request->has('email') ? 'email' : 'username';
            $loginValue = $request->input($loginField);

            $credentials = [
                $loginField => $loginValue,
                'password' => $request->password,
            ];

            if(Auth::attempt($credentials)){
                $user = Auth::user();
                $token = $user->createToken('auth_token')->plainTextToken;

                $user->profile->notify(new UserNotification(
                    'Welcome Back!',
                    'You have successfully logged in to your account.',
                    'login',
                    $user->users_id
                ));

                return response()->json([
                    'message' => 'Login successful',
                    'token' => $token,
                    'user_profile_id' => $user->profile_id,
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

        if (!$accessToken) {
            return response()->json(['error' => 'Access token is required'], 400);
        }

        try {
            $tokenInfo = Http::withOptions(
                ['verify' => false,]
            )->get(
                'https://oauth2.googleapis.com/tokeninfo?id_token=' . $idToken);

            if ($tokenInfo->getStatusCode() == 200) {

                try {

                    DB::beginTransaction();

                    $userProfile = UserProfileModel::updateOrCreate(
                        [
                            'email' => $tokenInfo->json('email'),
                            'provider' => 'google',
                        ],
                        [
                            'first_name' => $tokenInfo->json('given_name'),
                            'last_name' => $tokenInfo->json('family_name'),
                            'imageURL' => $tokenInfo->json('picture'),
                            'email' => $tokenInfo->json('email'),
                            'phone_number' => null,
                            'is_verified' => true,
                            'otp_code' => null,
                            'otp_code_expire_at' => null,
                        ]
                    );

                    SocialLoginModel::updateOrCreate(
                        [
                            'social_login_provider_id' => $tokenInfo->json('sub'),
                            'social_login_provider' => 'google',
                        ],
                        [
                            'profile_id' => $userProfile->user_profile_id,
                            'social_login_provider_id' => $tokenInfo->json('sub'),
                            'access_token' => $accessToken,
                        ]
                    );

                    $userModel = UserModel::updateOrCreate(
                        [
                            'profile_id' => $userProfile->user_profile_id,
                        ],
                        [
                            'username' => $tokenInfo->json('email') . $tokenInfo->json('sub'),
                            'password' => Hash::make($tokenInfo->json('sub')),
                            'email' => $tokenInfo->json('email'),
                        ]
                    );

                    DB::commit();

                    $userProfile->notify(new UserNotification(
                        'Welcome Back!',
                        'You have successfully logged in to your account.',
                        'login',
                        $userModel->users_id
                    ));

                    $token = $userModel->createToken('auth_token')->plainTextToken;

                    return response()->json([
                        'message' => 'Login with Google successful',
                        'access_token' => $token,
                        'user_profile_id' => $userModel->profile_id,
                        'token_type' => 'bearer'
                    ], 200);
                }catch (\Exception $exception){
                    DB::rollBack();
                    return response()->json(['error' => $exception->getMessage()], 500);
                }
            }

            return response()->json([
               'message' => 'Login with Google failed',
            ], 401);


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

           if ($tokenInfo->getStatusCode() == 200) {

               try{
                     DB::beginTransaction();

               $firstName = explode(' ', $tokenInfo->json('name'))[0];
               $lastName = explode(' ', $tokenInfo->json('name'))[1];
               $picture = $tokenInfo->json('picture');
               $picture = $picture['data'];
               $picture = $picture['url'];

               $userProfile = UserProfileModel::updateOrCreate(
                   [
                       'email' => $tokenInfo->json('email'),
                       'provider' => 'facebook',
                   ],
                   [
                       'first_name' => $firstName,
                       'last_name' => $lastName,
                       'image_url' => $picture,
                       'email' => $tokenInfo->json('email'),
                       'phone_number' => null,
                       'is_verified' => true,
                       'otp_code' => null,
                       'otp_code_expire_at' => null,
                   ]
               );

               SocialLoginModel::updateOrCreate(
                   [
                       'social_login_provider_id' => $tokenInfo->json('id'),
                       'social_login_provider' => 'facebook',
                   ],
                   [
                       'social_login_provider_id' => $tokenInfo->json('id'),
                       'access_token' => $accessToken,
                       'profile_id' => $userProfile->user_profile_id,
                   ]
               );

                $user = UserModel::updateOrCreate(
                     [
                          'profile_id' => $userProfile->user_profile_id,
                     ],
                     [
                          'username' => $tokenInfo->json('email') . $tokenInfo->json('id'),
                          'password' => Hash::make($tokenInfo->json('id')),
                     ]
                );

                DB::commit();

                $userProfile->notify(new UserNotification(
                    'Welcome Back!',
                    'You have successfully logged in to your account.',
                    'login',
                    $user->users_id
                ));

                $token = $user->createToken('auth_token')->plainTextToken;

               return response()->json([
                   'user_profile_id' => $userProfile->user_profile_id,
                   'message' => 'Login with Facebook successful',
                   'access_token' => $token,
                   'token_type' => 'bearer'
               ], 200);
               }catch (\Exception $exception){
                     DB::rollBack();
                     return response()->json(['error' => $exception->getMessage()], 500);
               }
           }

           return response()->json([
               'message' => 'login with Facebook failed',
           ], 401);

       }catch (\Exception $e){
           return response()->json(['error' => $e->getMessage()], 401);
       }
    }

    # Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout successful'], 200);
    }

    private function requestOTPCode() : int
    {
        return rand(1000, 9999);
    }

    private function checkExistingUser(Request $request)
    {
        return UserModel::where('username', $request->username)->exists() || UserProfileModel::where('email', $request->email)->exists();
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
