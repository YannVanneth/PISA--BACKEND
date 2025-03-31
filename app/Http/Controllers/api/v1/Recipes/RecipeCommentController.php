<?php

namespace App\Http\Controllers\api\v1\Recipes;

use App\Events\NewRecipeComment;
use App\Http\Controllers\Controller;
use App\Models\Recipes\RecipeCommentModel;
use App\Models\Recipes\RecipeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\UserNotification;
use App\Events\CommentReplyNotification;

class RecipeCommentController extends Controller
{
    /**
     * Get all comments for a specific recipe
     */
    public function index($recipeId)
    {
        $comments = RecipeCommentModel::with('profile')
            ->where('recipes_id', $recipeId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $comments
        ]);
    }

    /**
     * Store a new comment for a recipe
     */
    public function store(Request $request, $recipeId)
    {
        // Check if recipe exists
        $recipe = RecipeModel::findOrFail($recipeId);

        $request->validate([
            'comment_text' => 'required|string|max:1000',
            'parent_comment_id' => 'nullable|exists:recipe_comments,recipe_comments_id',
        ]);

        $comment = RecipeCommentModel::create([
            'recipes_id' => $recipeId,
            'profile_id' => Auth::user()->profile->user_profile_id,
            'comment_text' => $request->comment_text,
            'parent_comment_id' => $request->parent_comment_id,
        ]);

        // Load the profile relationship
        $comment->load('profile');

        // If this is a reply to another comment, send notification
        if ($request->parent_comment_id) {
            $parentComment = RecipeCommentModel::with('profile')->find($request->parent_comment_id);
            
            // Send notification to the user who wrote the parent comment
            if ($parentComment && $parentComment->profile_id !== Auth::user()->profile->user_profile_id) {
                $parentComment->profile->notify(new UserNotification(
                    'New Reply to Your Comment',
                    Auth::user()->profile->first_name . ' replied to your comment on ' . $recipe->title,
                    'comment_reply'
                ));

                // Broadcast the reply notification
                broadcast(new CommentReplyNotification($comment, $parentComment->profile))->dispatch();
            }
        }

        // Broadcast the new comment event
        broadcast(new NewRecipeComment($comment))->dispatch();

        return response()->json([
            'status' => 'success',
            'message' => 'Comment added successfully',
            'data' => $comment
        ], 201);
    }

    /**
     * Update a specific comment
     */
    public function update(Request $request, $recipeId, $commentId)
    {
        $comment = RecipeCommentModel::where('recipes_id', $recipeId)
            ->where('recipe_comments_id', $commentId)
            ->firstOrFail();

        // Check if the user owns this comment
        if ($comment->profile_id !== Auth::user()->profile->user_profile_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to update this comment'
            ], 403);
        }

        $request->validate([
            'comment_text' => 'required|string|max:1000',
        ]);

        $comment->update([
            'comment_text' => $request->comment_text,
        ]);

        // Load the profile relationship
        $comment->load('profile');

        // Broadcast the updated comment event
        broadcast(new NewRecipeComment($comment))->dispatch();

        return response()->json([
            'status' => 'success',
            'message' => 'Comment updated successfully',
            'data' => $comment
        ]);
    }

    /**
     * Delete a specific comment
     */
    public function destroy($recipeId, $commentId)
    {
        $comment = RecipeCommentModel::where('recipes_id', $recipeId)
            ->where('recipe_comments_id', $commentId)
            ->firstOrFail();

        // Check if the user owns this comment
        if ($comment->profile_id !== Auth::user()->profile->user_profile_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized to delete this comment'
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Comment deleted successfully'
        ]);
    }
} 