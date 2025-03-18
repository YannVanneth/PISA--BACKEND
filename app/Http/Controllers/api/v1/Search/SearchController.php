<?php

namespace App\Http\Controllers\api\v1\Search;

use App\Http\Controllers\Controller;
use App\Models\Ingredients\IngredientModel;
use App\Models\Recipes\RecipeModel;
use Google\Service\ContainerAnalysis\Recipe;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Validate the request
        $request->validate([
            'ingredients' => 'required|string',
        ]);

        // Split the ingredients string into an array, trim whitespace, and convert to lowercase
        $ingredients = array_map('trim', explode(',', $request->input('ingredients')));
        $ingredients = array_map('strtolower', $ingredients); // Convert to lowercase

        // Get all recipe IDs that have at least one of the ingredients or match the recipe name (case-insensitive search)
        $recipeIds = IngredientModel::where(function($query) use ($ingredients) {
            foreach ($ingredients as $ingredient) {
                $query->orWhereRaw('LOWER(ingredients_name_en) LIKE ?', ['%' . $ingredient . '%'])
                    ->orWhereRaw('LOWER(ingredients_name_km) LIKE ?', ['%' . $ingredient . '%']);
            }
        })->pluck('recipes_id')->unique();

        // Also search for recipes by name
        $recipeIdsByName = RecipeModel::where(function($query) use ($ingredients) {
            foreach ($ingredients as $ingredient) {
                $query->orWhereRaw('LOWER(recipes_title_en) LIKE ?', ['%' . $ingredient . '%'])
                    ->orWhereRaw('LOWER(recipes_title_km) LIKE ?', ['%' . $ingredient . '%']);
            }
        })->pluck('recipes_id')->unique();

        // Combine the two sets of recipe IDs and remove duplicates
        $allRecipeIds = $recipeIds->merge($recipeIdsByName)->unique();

        // If no matching recipes found
        if ($allRecipeIds->isEmpty()) {
            return response()->json(['message' => 'No recipes found for these ingredients or name.'], 404);
        }

        // Get recipes with their related models
        $recipes = RecipeModel::with(['category', 'cookingInstructions', 'cookingSteps', 'ingredients'])
            ->whereIn('recipes_id', $allRecipeIds)
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
