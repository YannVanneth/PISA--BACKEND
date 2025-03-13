<?php

namespace App\Http\Controllers\api\v1\User;

use App\Http\Controllers\Controller;
use App\Models\User\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return UserModel::all();
    }

    public function store(Request $request)
    {
        return UserModel::create($request->all());
    }

    public function show($id)
    {
        return UserModel::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $user = UserModel::findOrFail($id);
        $user->update($request->all());
        return $user;
    }

    public function destroy($id)
    {
        UserModel::destroy($id);
        return response()->noContent();
    }
}
