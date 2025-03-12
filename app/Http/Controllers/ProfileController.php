<?php

namespace App\Http\Controllers;

use App\Models\profile;
use Illuminate\Http\Request;

class ProfileController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Profile::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $profile = Profile::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'picture' => $request->picture,
                'email' => $request->email,
                'phone' => $request->phone,
                'is_verify' => $request->is_verify,
                'otp_code' => $request->otp_code,
                'otp_expires_at' => $request->otp_expires_at
            ]);
            return response()->json([
                'message' => 'Profile created successfully',
                'data' => $profile
            ], 201);

        } catch(\Throwable $th) {
            return response()->json([
                'message' => 'Profile create file',
                'error' => $th -> getMessage()
            ], 400);         
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Profile::findOrfail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        try {
            $profile->update([
                'first_name' => $request->first_name ?? $profile->first_name,
                'last_name' => $request->last_name ?? $profile->last_name,
                'picture' => $request->picture ?? $profile->picture,
                'email' => $request->email ?? $profile->email,
                'phone' => $request->phone ?? $profile->phone,
                'is_verify' => $request->is_verify ?? $profile->is_verify,
                'otp_code' => $request->otp_code ?? $profile->otp_code,
                'otp_expires_at' => $request->otp_expires_at ?? $profile->otp_expires_at
            ]);

            return response()->json([
                'message' => 'Profile updated successfully',
                'data' => $profile
            ], 200);
        } catch(\Throwable $th) {
            return response()->json([
                'message' => 'Profile update fail',
                'error' => $th -> getMessage()
            ], 400);         
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        try {
            $profile->delete();
            return response()->json([
                'message' => 'Profile deleted successfully.'
            ], 200);
        } catch(\Throwable $th) {
            return response()->json([
                'message' => 'Profile delete fail.',
                'error' => $th->getMessage()
            ], 400);
        }
    }
}
