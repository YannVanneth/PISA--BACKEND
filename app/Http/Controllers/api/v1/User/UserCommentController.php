<?php

namespace App\Http\Controllers\api\v1\User;

use App\Events\CommentPosted;
use App\Http\Controllers\Controller;
use App\Http\Resources\api\v1\UserCommentModelResource;
use App\Models\User\UserCommentModel;
use Illuminate\Http\Request;

class UserCommentController extends Controller
{
    public function index(Request $request)
    {
        if($request->query('recipes_id')){

            $recipes = UserCommentModel::where('recipes_id', $request->query('recipes_id'))->get();

            return \response()->json([
                'message' => 'Comments for recipe',
                'data' => UserCommentModelResource::collection($recipes)
            ]);
        }

        return response()->json([
            'message' => 'All comments',
            'data' => UserCommentModelResource::collection(UserCommentModel::all())
        ]);
    }

    public function handleCommentReply(Request $request)
    {
        try{

            $request->validate([
                'users_comment_id' => 'required|integer',
                'recipes_id' => 'required|integer',
                'profile_id' => 'required|integer',
                'replies' => 'required|string',
            ]);

            $existingComment = UserCommentModel::where('users_comment_id', $request->users_comment_id)
                ->where('recipes_id', $request->recipes_id)
                ->where('profile_id', $request->profile_id)
                ->first();

            if (!$existingComment) {
                return response()->json([
                    'message' => 'Comment not found',
                ], 404);
            }

            $existingComment->update([
                'replies' => $request->replies,
            ]);

            return response()->json([
                'message' => 'Comment updated successfully',
                'data' => $existingComment
            ]);

        }catch (\Exception $exception){
            return response()->json([
                'error' => $exception->getMessage(),
                'message' => 'Ops! Something when wrong!'
            ], 500);
        }
    }

    public function handleComment(Request $request)
    {
        try{

            $request->validate(
                [
                    'recipes_id' => 'required|exists:recipes,recipes_id',
                    'profile_id' => 'required|exists:user_profile,user_profile_id',
                    'react_count' => 'required|integer',
                    'comment_content' => 'required|string|max:1000',
                    'is_verified' => 'nullable|boolean',
                    'is_liked' => 'nullable|boolean',
                    'replies' => 'nullable|string|max:2000',
                ]);

            $userComment = UserCommentModel::create($request->all());

            return response()->json([
                'message' => 'Comment posted successfully',
                'data' => new UsercommentModelResource($userComment)
            ]);

        }catch (\Exception $exception){
            return response()->json([
                'error' => $exception->getMessage(),
                'message' => 'Ops! Something when wrong!'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try{

            $request->validate([
                'recipe_id' => 'required',
                'profile_id' => 'required',
                'react_count' => 'required',
                'comment_content' => 'required',
                'parent_comment_id' => 'nullable',
                'is_verified' => 'nullable',
                'is_liked' => 'nullable',
                'replies' => 'nullable',
            ]);

            $userComment = UserCommentModel::create($request->all());

            event(new CommentPosted($request->recipe_id, $userComment));

            return $userComment;

        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage(), 'message' => 'Ops! Something when wrong!'], 500);
        }
    }

    public function show($id)
    {
        try{
            $comment = UserCommentModel::find($id);

            if(!$comment){
                return response()->json(['message' => 'comment not found!'], 404);
            }

            return $comment;
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage(), 'message' => 'Ops! Something when wrong!'], 500);
        }
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
