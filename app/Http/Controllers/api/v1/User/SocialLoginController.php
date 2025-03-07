<?php

namespace App\Http\Controllers\api\v1\User;

use App\Http\Controllers\Controller;
use App\Models\User\SocialLoginModel;
use Illuminate\Http\Request;

class SocialLoginController extends Controller
{
    public function index()
    {
        return SocialLoginModel::all();
    }

    public function store(Request $request)
    {
        return SocialLoginModel::create($request->all());
    }

    public function show($id)
    {
        return SocialLoginModel::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $socialLogin = SocialLoginModel::findOrFail($id);
        $socialLogin->update($request->all());
        return $socialLogin;
    }

    public function destroy($id)
    {
        SocialLoginModel::destroy($id);
        return response()->noContent();
    }
}
