<?php

namespace App\Http\Controllers\api\v1\WishList;

use App\Http\Controllers\Controller;
use App\Models\User\UserProfileModel;
use App\Models\WishList\WishListModel;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'recipe_id' => 'required|integer',
            'profile_id' => 'required|integer',
        ]);

        // Check if already in wishlist to avoid duplicates
        $exists = WishListModel::where('recipe_id', $request->recipe_id)
            ->where('profile_id', $request->profile_id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Already in wishlist'], 409);
        }

        // Create wishlist entry
        $wishlist = WishListModel::create([
            'recipe_id' => $request->recipe_id,
            'profile_id' => $request->profile_id,
        ]);

        return response()->json([
            'message' => 'Added to wishlist',
            'wishlist' => $wishlist
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wishlistItem = WishListModel::query()->find($id);
        if ($wishlistItem !== null) {
            $wishlistItem->delete();
            return response()->json(['message' => 'Deleted from wishlist'], 200);
        }
        return response()->json(['message' => 'Not found'], 404);
    }
}
