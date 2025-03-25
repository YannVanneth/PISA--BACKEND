<?php

namespace App\Http\Controllers\api\v1\Search;

use App\Http\Controllers\Controller;
use App\Models\Ingredients\IngredientModel;
use App\Models\Recipes\RecipeCategoryModel;
use App\Models\Recipes\RecipeModel;
use Google\Service\ContainerAnalysis\Recipe;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function searchByIngredients(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'ingredients' => 'required|string',
        ]);

        $ingredients = array_map('trim', explode(',', $request->input('ingredients')));
        $ingredients = array_map('strtolower', $ingredients);

        // Correctly pluck 'ingredients_id'
        $matchedIngredientIds = IngredientModel::where(function ($query) use ($ingredients) {
            foreach ($ingredients as $ingredient) {
                $query->orWhereRaw('LOWER(ingredients_name_en) LIKE ?', ['%' . $ingredient . '%'])
                    ->orWhereRaw('LOWER(ingredients_name_km) LIKE ?', ['%' . $ingredient . '%']);
            }
        })->pluck('ingredients_id');

        if ($matchedIngredientIds->isEmpty()) {
            return response()->json([], 200);
        }

        $recipes = RecipeModel::with(['category', 'cookingInstructions', 'cookingSteps', 'ingredients'])
            ->whereHas('ingredients', function ($query) use ($matchedIngredientIds) {
                $query->whereIn('ingredients_id', $matchedIngredientIds);
            })
            ->get();

        return response()->json($recipes);
    }

    public function searchByCategory(Request $request): \Illuminate\Http\JsonResponse
    {
        // Validate the category input
        $request->validate([
            'category' => 'required|string',
        ]);

        // Retrieve the category from the request
        $category = strtolower(trim($request->input('category')));

        // Split the category into individual words
        $words = explode(' ', $category);

        // Find category IDs using LIKE for better matching (case-insensitive, trimming spaces)
        $categoryIds = RecipeCategoryModel::where(function ($query) use ($words) {
            foreach ($words as $word) {
                $query->orWhereRaw('LOWER(TRIM(recipe_categories_en)) LIKE ?', ['%' . $word . '%'])
                    ->orWhereRaw('LOWER(TRIM(recipe_categories_km)) LIKE ?', ['%' . $word . '%']);
            }
        })->pluck('recipe_categories_id')->unique();

        // Check if category IDs were found
        if ($categoryIds->isEmpty()) {
            return response()->json(['message', 'product not found!'], 401);
        }

        // Get recipes with the matching category IDs
        $recipes = RecipeModel::with(['category', 'cookingInstructions', 'cookingSteps', 'ingredients'])
            ->whereIn('recipe_categories_id', $categoryIds)
            ->get();

        // Return the recipes in the response
        return response()->json($recipes);
    }


    public function searchByRecipes(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'recipeName' => 'required|string',
        ]);

        $userInput = strtolower(trim($request->input('recipeName')));

        // Get all recipes with Khmer and English titles
        $allRecipes = RecipeModel::with(['category', 'cookingInstructions', 'cookingSteps', 'ingredients'])->get();

        // Filter recipes based on character count validation
        $filteredRecipes = $allRecipes->filter(function ($recipe) use ($userInput) {
            $dbTitleEn = strtolower($recipe->recipes_title_en);
            $dbTitleKm = strtolower($recipe->recipes_title_km);

            return $this->matchesCharacterLimit($userInput, $dbTitleEn) || $this->matchesCharacterLimit($userInput, $dbTitleKm);
        });

        return response()->json($filteredRecipes->values());
    }

    /**
     * Check if user input matches character limits of the given recipe title.
     */
    function matchesCharacterLimit($userInput, $recipeTitle): bool
    {
        $dbCharCount = array_count_values(str_split($recipeTitle));
        $inputCharCount = array_count_values(str_split($userInput));

        foreach ($inputCharCount as $char => $count) {
            if (!isset($dbCharCount[$char]) || $count > $dbCharCount[$char]) {
                return false; // Reject if user input exceeds the character count in the recipe name
            }
        }

        return true; // Accept if the user input is within the valid limits
    }


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
        $recipeIds = IngredientModel::where(function ($query) use ($ingredients) {
            foreach ($ingredients as $ingredient) {
                $query->orWhereRaw('LOWER(ingredients_name_en) LIKE ?', ['%' . $ingredient . '%'])
                    ->orWhereRaw('LOWER(ingredients_name_km) LIKE ?', ['%' . $ingredient . '%']);
            }
        })->pluck('recipes_id')->unique();

        // Also search for recipes by name
        $recipeIdsByName = RecipeModel::where(function ($query) use ($ingredients) {
            foreach ($ingredients as $ingredient) {
                $query->orWhereRaw('LOWER(recipes_title_en) LIKE ?', ['%' . $ingredient . '%'])
                    ->orWhereRaw('LOWER(recipes_title_km) LIKE ?', ['%' . $ingredient . '%']);
            }
        })->pluck('recipes_id')->unique();

        //Also search for recipes by category
        $recipesIdsBycategory = RecipeCategoryModel::where(function ($query) use ($ingredients) {
            foreach ($ingredients as $ingredient) {
                $query->orWhereRaw('LOWER(recipe_categories_en) LIKE ?', ['%' . $ingredient . '%'])
                    ->orWhereRaw('LOWER(recipe_categories_km) LIKE ?', ['%' . $ingredient . '%']);
            }
        })->pluck('recipe_categories_id')->unique();
        $recipeIdsByCategory = RecipeModel::whereIn('recipe_categories_id', $recipesIdsBycategory)->pluck('recipes_id')->unique();

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
