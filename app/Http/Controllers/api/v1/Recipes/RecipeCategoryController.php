<?php

namespace App\Http\Controllers\api\v1\Recipes;

use App\Http\Controllers\Controller;
use App\Models\Recipes\RecipeCategory;
use Illuminate\Http\Request;

class RecipeCategoryController extends Controller
{
    public function index()
    {
        return RecipeCategory::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipe_categories_km' => 'required|string',
            'recipe_categories_en' => 'required|string',
            'imageURl' => 'required|string',
        ]);

        return RecipeCategory::create($request->all());
    }

    public function show($id)
    {
        return RecipeCategory::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $recipeCategory = RecipeCategory::findOrFail($id);
        $recipeCategory->update($request->all());
        return $recipeCategory;
    }

    public function destroy($id)
    {
        RecipeCategory::destroy($id);
        return response()->noContent();
    }
}
