<?php

namespace App\Http\Controllers\mail;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Controller;
use App\Mail\VerifyOTPMail;
use App\Models\User\UserProfileModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail as MailFacade;

class MailController extends Controller
{
    public function forgotMail(Request $request)
    {
        try{
            $receiver = $request->query('email');
            $isResend = $request->query('isResend');

            $user = UserProfileModel::where('email', $receiver)->first();

            if($isResend == 'true' && $user){

                $auth = new AuthController();

                $user->update([
                    'otp_code' => $auth->requestOTPCode(),
                    'otp_code_expire_at' => now()->addMinutes(10)
                ]);
            }

            if(!$user){
                MailFacade::to($receiver)->send(new VerifyOTPMail(
                    "Sorry, we couldn't find an account with that email address. Please check your email and try again.",
                    "",
                    "",
                    "",
                    false,
                    $user != null

                ));
            }

            MailFacade::to($receiver)->send(new VerifyOTPMail(
                "We've received a request to access your account. To ensure it's really you and protect your account, please use the verification code below:",
                $user->otp_code,
                $user->first_name . " " . $user->last_name,
                10,
                false,
                $user != null

            ));
        }catch (\Exception $e){
            return $e->getMessage();
        }
        return response()->json(['message' => $receiver . ' Email is Sent.']);
    }

    public function RegisterMail(Request $request)
    {
        try {

            $receiver = $request->query('email');
            $isResend = $request->query('isResend');

            $user = UserProfileModel::where('email', $receiver)->first();

            if($isResend == 'true'){

                $auth = new AuthController();

                $user->update([
                    'otp_code' => $auth->requestOTPCode(),
                    'otp_code_expire_at' => now()->addMinutes(10)
                ]);
            }


            MailFacade::to($receiver)->send(new VerifyOTPMail(
                "Thank you for registering with " . config('app.name') . ". To complete your account verification, please use the One-Time Password (OTP) provided below:",
                $user->otp_code,
                $user->first_name . " " . $user->last_name,
                10,
                true,

            ));

        }catch (\Exception $e){
            return $e->getMessage();
        }

        return "Email is Sent.";
    }

    public function verifyOTP(Request $request){
        try {

            $user = UserProfileModel::where([
                'email' => $request->query('email'),
                'otp_code' => $request->query('otp_code')
            ])->first();

            if (!$user) {
                return response()->json([
                    'is_valid' => false,
                    'message' => 'Invalid OTP or email.'
                ], 400);
            }

            return response()->json([
                'is_valid' => true,
                'user' => $user
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'is_valid' => false,
                'message' => 'Something went wrong. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
