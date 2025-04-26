<?php

namespace App\Http\Controllers\api\v1\User;

use App\Events\CommentPost;
use App\Http\Controllers\Controller;
use App\Http\Resources\api\v1\UserCommentModelResource;
use App\Models\User\CommentReactionModel;
use App\Models\User\UserCommentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserCommentController extends Controller
{
    public function index(Request $request)
    {
        $recipeId = $request->query('recipe_id');

        if ($recipeId) {
            $comments = UserCommentModel::with(['profile', 'replies.profile','replies.parentComment.profile'])
                ->where('recipe_id', $recipeId)
                ->whereNull('parent_comment_id')
                ->orderBy('created_at', 'asc')
                ->get();

            if ($comments->isEmpty()) {
                return response()->json([
                    'message' => 'No comments found for this recipe',
                ], 404);
            }
            return response()->json([
                'message' => 'Comments for recipe',
                'data' => UserCommentModelResource::collection($comments),
            ]);
        }

        return response()->json([
            'message' => 'All comments',
            'data' => UserCommentModelResource::collection(UserCommentModel::all())
        ]);
    }

    public function handleCommentReaction(Request $request)
    {
        try {
            $request->validate([
                'comment_id' => 'required|integer',
                'is_liked' => 'required|boolean',
            ]);

            $userComment = UserCommentModel::find($request->comment_id);

            if (!$userComment) {
                return response()->json([
                    'message' => 'Comment not found',
                    'error' => 'Comment not found'
                ], 404);
            }

            DB::beginTransaction();
            $existingReaction = CommentReactionModel::where('comment_id', $request->comment_id)
                ->where('user_id', auth()->id())
                ->first();

            $reaction = CommentReactionModel::updateOrCreate(
                [
                    'comment_id' => $request->comment_id,
                    'user_id' => auth()->id(),
                ],
                [
                    'is_liked' => $request->is_liked,
                ]
            );

            $comment = UserCommentModel::find($request->comment_id);

            if ($existingReaction) {
                if ($request->is_liked) {
                    $comment->increment('react_count');
                } else {
                    $comment->decrement('react_count');
                }
            } else {
                $comment->increment('react_count');
            }
            DB::commit();

            return response()->json([
                'message' => 'Reaction updated successfully',
                'data' => $reaction
            ]);

        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'error' => $exception->getMessage(),
                'message' => 'Oops! Something went wrong!'
            ], 500);
        }
    }

    public function handleComment(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'recipes_id' => 'required',
                'contents' => 'required|string|max:1000',
            ]);

            $userComment = UserCommentModel::create([
                'recipe_id' => $request->recipes_id,
                'profile_id' => auth()->id(),
                'content' => $request->contents,
                'parent_comment_id' => $request->parent_comment_id ?? null,
            ]);

            $userComment->load('replies');

            broadcast(new CommentPost($userComment));

            DB::commit();

            return response()->json([
                'message' => 'Comment posted successfully',
                'data' => new UserCommentModelResource($userComment),
            ]);

        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'error' => $exception->getMessage(),
                'message' => 'Ops! Something went wrong!',
            ], 500);
        }
    }

}
