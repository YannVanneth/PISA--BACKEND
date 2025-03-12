<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\Http\Request;

class UserController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = User::create([
                'username' => $request->username,
                'password' => $request->password,
                'profile_id' => $request->profile_id,
            ]);

            return response()->json([
                'message' => 'User created successfully.',
                'data' => $user
            ], 201);
        } catch(\Throwable $th) {
            return response()->json([
                'message' => 'Create user fail.',
                'error' => $th -> getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return User::findOrfail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, user $user)
    {
        try {
            $user->update([
                'username' => $request->username ?? $user->username,
                'password' => $request->password ?? $user->password,
                'profile_id' => $request->profile_id ?? $user->profile_id,
            ]);

            return response()->json([
                'message' => 'User updated successfully.',
                'data' => $user
            ], 200);
        } catch(\Throwable $th) {
            return response()->json([
                'message' => 'User udate fail.',
                'error' => $th -> getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        try {
            $user->delete();

            return response()->json([
                'message' => 'User deleted successfully.'
            ], 200);
        } catch(\Throwable $th) {
            return response()->json([
                'message' => 'User delete fail.',
                'error' => $th->getMessage()
            ], 400);
        }
    }
}
