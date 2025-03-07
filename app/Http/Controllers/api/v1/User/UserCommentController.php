<?php

namespace App\Http\Controllers\api\v1\User;

use App\Http\Controllers\Controller;
use App\Models\User\UserCommentModel;
use Illuminate\Http\Request;

class UserCommentController extends Controller
{
    public function index()
    {
        return UserCommentModel::all();
    }

    public function store(Request $request)
    {
        return UserCommentModel::create($request->all());
    }

    public function show($id)
    {
        return UserCommentModel::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $userComment = UserCommentModel::findOrFail($id);
        $userComment->update($request->all());
        return $userComment;
    }

    public function destroy($id)
    {
        UserCommentModel::destroy($id);
        return response()->noContent();
    }
}
