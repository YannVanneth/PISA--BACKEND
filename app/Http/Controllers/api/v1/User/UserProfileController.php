<?php

namespace App\Http\Controllers\api\v1\User;

use App\Http\Controllers\Controller;
use App\Models\User\UserModel;
use App\Models\User\UserProfileModel;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function index()
    {
        return UserProfileModel::all();
    }

    public function store(Request $request)
    {
        return UserProfileModel::create($request->all());
    }

    public function show($id)
    {
        return UserProfileModel::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $userProfile = UserProfileModel::findOrFail($id);
        $userProfile->update($request->all());
        return $userProfile;
    }

    public function destroy($id)
    {
        UserProfileModel::destroy($id);
        return response()->noContent();
    }

    public function checkExistingUser(Request $request)
    {
        try{
            $username = $request->query('username');
            $email = $request->query('email');

            $user = UserProfileModel::where('email', $email)->first();
            $username = UserModel::where('username', $username)->first();

            if($user || $username){
                return response()->json([
                    'message' => 'Username or Email already exists',
                    'is_available' => false
                ], 200);
            };

            return response()->json([
                'message' => 'Username and Email available',
                'is_available' => true
            ], 200);

        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage(), 'message' => 'Oops! Something went wrong.'], 500);
        }
    }
}
