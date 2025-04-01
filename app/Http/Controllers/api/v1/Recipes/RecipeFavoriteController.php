<?php

namespace App\Http\Controllers\api\v1\Recipes;

use App\Http\Controllers\Controller;
use App\Models\Recipes\RecipeFavoriteModel;
use App\Models\WishList\WishListModel;
use Illuminate\Http\Request;

class RecipeFavoriteController extends Controller
{
    public function index()
    {
        return RecipeFavoriteModel::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipes_id' => 'required|integer|exists:recipes,recipes_id',
            'profile_id' => 'required|integer|exists:user_profile,user_profile_id',
            'favorite_status' => 'sometimes|boolean'
        ]);

        $existingFavorite = RecipeFavoriteModel::where('recipes_id', $validated['recipes_id'])
            ->where('profile_id', $validated['profile_id'])
            ->first();

        if ($existingFavorite) {
            return response()->json([
                'message' => 'Recipe already added to favorites',
                'data' => $existingFavorite
            ], 200);
        }

        $favorite = RecipeFavoriteModel::create([
            'recipes_id' => $validated['recipes_id'],
            'profile_id' => $validated['profile_id'],
            'favorite_status' => $validated['favorite_status'] ?? 1,
        ]);

        return response()->json([
            'message' => 'Added to favorites successfully',
            'data' => $favorite
        ], 201);
    }

    public function show($id)
    {
        return RecipeFavoriteModel::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'favorite_status' => 'required|boolean',
            'recipes_id' => 'sometimes|integer|exists:recipes,id',
            'profile_id' => 'sometimes|integer|exists:profiles,id'
        ]);

        // Convert boolean to integer for favorite_status
        if (isset($validated['favorite_status'])) {
            $validated['favorite_status'] = (int)$validated['favorite_status'];
        }

        $recipeFavorite = RecipeFavoriteModel::findOrFail($id);
        $recipeFavorite->update($validated);

        return response()->json([
            'success' => true,
            'data' => $recipeFavorite,
            'message' => 'Record updated successfully'
        ]);
    }

    // FavoriteController.php
    public function destroy(Request $request)
    {
        $request->validate([
            'recipes_id' => 'required|integer',
            'profile_id' => 'required|integer',
        ]);

        $favoriteItem = RecipeFavoriteModel::where('recipes_id', $request->recipes_id)
            ->where('profile_id', $request->profile_id)
            ->first();

        if ($favoriteItem !== null) {
            $favoriteItem->delete();
            return response()->json([
                'success' => true,
                'message' => 'Deleted from favorites',
                'deleted_data' => [
                    'recipes_id' => $request->recipes_id,
                    'profile_id' => $request->profile_id
                ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Favorite item not found'
        ], 404);
    }
}
