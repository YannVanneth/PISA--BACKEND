<?php

namespace App\Http\Controllers\mail;

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
            $request->validate([
                'email' => 'required|email'
            ]);

            $receiver = $request->input('email');

            # check if the email is registered in the database
            $user = UserProfileModel::where('email', $receiver)->first();

            if(!$user){
                return response()->json(['message' => 'Email is not registered'], 404);
            }

            MailFacade::to($receiver)->send(new VerifyOTPMail(
                "We've received a request to access your account. To ensure it's really you and protect your account, please use the verification code below:",
                $user->otp_code,
                $user->first_name . " " . $user->last_name,
                10
            ));
        }catch (\Exception $e){
            return $e->getMessage();
        }
        return response()->json(['message' => $receiver . ' Email is Sent.']);
    }

    public function RegisterMail(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email'
            ]);

            $receiver = $request->input('email');

            $user = UserProfileModel::where('email', $receiver)->first();

            MailFacade::to($receiver)->send(new VerifyOTPMail(
                "Thank you for registering with " . config('app.name') . ". To complete your account verification, please use the One-Time Password (OTP) provided below:",
                $user->otp_code,
                $user->first_name . " " . $user->last_name,
                10
            ));

        }catch (\Exception $e){
            return $e->getMessage();
        }

        return "Email is Sent.";
    }

    public function verifyOTP(Request $request){
        try {
            $request->validate([
                'email' => 'required|email',
                'otp_code' => 'required',
            ]);

            $user = UserProfileModel::where([
                'email' => $request->email,
                'otp_code' => $request->otp_code
            ])->first();

            if (!$user) {
                return response()->json([
                    'isValid' => false,
                    'message' => 'Invalid OTP or email.'
                ], 400);
            }

            return response()->json([
                'isValid' => true,
                'user' => $user
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'isValid' => false,
                'message' => 'Something went wrong. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
