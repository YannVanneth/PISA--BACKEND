<?php

namespace App\Http\Controllers\api\v1\Recipes;

use App\Http\Controllers\Controller;
use App\Http\Resources\api\v1\RecipeRatingResource;
use App\Http\Resources\api\v1\RecipesResource;
use App\Models\Recipes\RecipeModel;
use App\Models\Recipes\RecipeRatingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isEmpty;

class RecipeRatingController extends Controller
{
    public function index()
    {
        return RecipeRatingModel::all();
    }

    public function store(Request $request)
    {
        $recipesId = $request->query('recipes_id');
        $profileId = $request->query('profile_id');
        $ratingValue = $request->query('rating_value');

        $validator = Validator::make([
            'recipes_id' => $recipesId,
            'profile_id' => $profileId,
            'rating_value' => $ratingValue,
        ], [
            'recipes_id' => 'required|exists:recipes,recipes_id',
            'profile_id' => 'required|exists:user_profile,user_profile_id',
            'rating_value' => 'required|integer|between:1.0,5.0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'details' => $validator->errors()
            ], 422);
        }

        $existingRating = RecipeRatingModel::where('recipes_id', $recipesId)
            ->where('profile_id', $profileId)
            ->first();

        if ($existingRating) {
            if ($existingRating->rating_value == $ratingValue) {
                $existingRating->rating_value = 0;
            } else {
                $existingRating->rating_value = $ratingValue;
            }
            $existingRating->save();
            return response()->json($existingRating, 200);
        }

        $newRating = RecipeRatingModel::create([
            'recipes_id' => $recipesId,
            'profile_id' => $profileId,
            'rating_value' => $ratingValue,
        ]);

        return response()->json($newRating, 201);
    }



    public function show($id)
    {
        return RecipeRatingModel::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'recipes_id' => 'sometimes|required|exists:recipes,recipes_id',
            'profile_id' => 'sometimes|required|exists:user_profile,profile_id',
            'rating_value' => 'sometimes|required|integer|between:1,5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'details' => $validator->errors()
            ], 422);
        }

        $recipeRating = RecipeRatingModel::findOrFail($id);
        $recipeRating->update($request->all());

        return $recipeRating;
    }

    public function destroy($id)
    {
        RecipeRatingModel::destroy($id);
        return response()->noContent();
    }
    public function getByRecipe(Request $request): \Illuminate\Http\JsonResponse
    {
        $recipe_id =  $request->query('recipes_id');

        $ratingSummary = RecipeRatingModel::where('recipes_id', $recipe_id)
            ->selectRaw('SUM(rating_value) as total_rating, COUNT(profile_id) as total_users')
            ->first();
        $result = [
            'recipe_id' => $recipe_id,
            'total_rating' => $ratingSummary->total_rating ?? 0,
            'total_users' => $ratingSummary->total_users ?? 0,
            'average_rating' => $ratingSummary->total_users > 0
                ? round($ratingSummary->total_rating / $ratingSummary->total_users, 1)
                : 0
        ];

        return response()->json($result, 200);
    }

    public function getByProfile($profile_id)
    {
        return RecipeRatingModel::where('profile_id', $profile_id)->get();
    }
    public function getByRecipeAndProfile(Request $request): \Illuminate\Http\JsonResponse
    {
        // Get query parameters
        $recipe_id = $request->query('recipes_id');
        $profile_id = $request->query('profile_id');

        // Validate query parameters
        if (!isset($recipe_id) || !isset($profile_id)) {
            return response()->json(['error' => 'Both recipes_id and profile_id are required'], 400);
        }

        try {
            // Fetch ratings based on query parameters - this is the correct approach
            $ratings = RecipeRatingModel::with(['recipes', 'profile'])
                ->where('recipes_id', $recipe_id)
                ->where('profile_id', $profile_id)
                ->get();

            if ($ratings->isEmpty()) {
                return response()->json(['message' => 'No ratings found for this recipe and profile combination'], 404);
            }

            $data = RecipeRatingResource::collection($ratings);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
