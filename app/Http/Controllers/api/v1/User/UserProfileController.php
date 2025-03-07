<?php

namespace App\Http\Controllers\api\v1\User;

use App\Http\Controllers\Controller;
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
}
