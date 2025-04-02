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

        try {
            $validated = $request->validate([
                'recipes_id' => 'required|integer|exists:recipes,recipes_id',
                'profile_id' => 'required|integer|exists:user_profile,user_profile_id',
                'favorite_status' => 'sometimes|integer'
            ]);

            $favoriteStatus = (string)($validated['favorite_status'] ?? '1') === '1';

            $exists = RecipeFavoriteModel::where('recipes_id', $validated['recipes_id'])
                ->where('profile_id', $validated['profile_id'])
                ->exists();

            if ($exists) {
                return response()->json(['message' => 'This recipe is already in your favorites'], 409);
            }

            RecipeFavoriteModel::create([
                'recipes_id' => $validated['recipes_id'],
                'profile_id' => $validated['profile_id'],
                'favorite_status' => $favoriteStatus
            ]);
            return response()->json(['message' => 'Recipe added to favorites successfully'], 201);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }


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

    public function getByProfile(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validated = $request->validate([
                'per_page' => 'required|integer|min:1|max:100',
                'page' => 'required|integer|min:1',
                'profile_id' => 'required|integer|exists:user_profile,user_profile_id',
            ]);

            $favorites = RecipeFavoriteModel::where('profile_id', $validated['profile_id'])
                ->with(['recipe' => function($query) {
                    $query->select([
                        'recipes_id',
                        'recipes_title_km',
                        'recipes_title_en',
                        'recipes_image_url'
                    ]);
                }])
                ->paginate(
                    $validated['per_page'],
                    ['*'],
                    'page',
                    $validated['page']
                );

            return response()->json([
                'success' => true,
                'data' => $favorites->items(),
                'pagination' => [
                    'current_page' => $favorites->currentPage(),
                    'per_page' => $favorites->perPage(),
                    'total' => $favorites->total(),
                    'last_page' => $favorites->lastPage(),
                ]
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}
