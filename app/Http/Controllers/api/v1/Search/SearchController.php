<?php

namespace App\Http\Controllers\api\v1\Search;

use App\Http\Controllers\Controller;
use App\Models\Ingredients\IngredientModel;
use Google\Service\ContainerAnalysis\Recipe;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'ingredients' => 'required|string',
        ]);

        // Split the ingredients string into an array
        $ingredients = array_map('trim', explode(',', $request->input('ingredients')));

        // Get all recipe IDs that have at least one of the ingredients
        $recipeIds = IngredientModel::where(function($query) use ($ingredients) {
            foreach ($ingredients as $ingredient) {
                $query->orWhere('ingredients_name_en', 'like', '%' . $ingredient . '%');
            }
        })->pluck('recipes_id')->unique();

        // If no matching recipes found
        if ($recipeIds->isEmpty()) {
            return response()->json(['message' => 'No recipes found for these ingredients.'], 404);
        }

        // Get recipes with their related models
        $recipes = RecipeModel::with(['category', 'cookingInstructions', 'cookingSteps', 'ingredients'])
            ->whereIn('recipes_id', $recipeIds)
            ->get();

        return response()->json($recipes);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
