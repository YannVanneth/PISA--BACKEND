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

    public function commentReply(Request $request)
    {
        try{

            $request->validate([
                'profile_id' => 'required|exists:users,profile_id',
                'reply_content' => 'required|string|max:1000',
                'parent_comment_id' => 'required|exists:comments,id',
            ]);

            $user = UserModel::where('profile_id', $request->profile_id)->firstOrFail();

            $user->notify(new CommentReply(
                $request->profile_id,
                $request->reply_content,
                $request->parent_comment_id
            ));

            return response()->json([
                'message' => 'Reply notification sent successfully',
            ], 200);

        }catch (\Exception $exception){
            return response()->json([
                'error' => $exception->getMessage(),
                'message' => 'Ops! Something went wrong!',
            ], 500);
        }

    }
}
