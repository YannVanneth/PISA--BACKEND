<?php

namespace App\Http\Controllers\api\v1\Recipes;

use App\Http\Controllers\Controller;
use App\Models\Recipes\RecipeCategoryModel;
use Illuminate\Http\Request;

class RecipeCategoryController extends Controller
{
    public function index()
    {
        return RecipeCategoryModel::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipe_categories_km' => 'required|string',
            'recipe_categories_en' => 'required|string',
            'imageURl' => 'required|string',
        ]);

        return RecipeCategoryModel::create($request->all());
    }

    public function show($id)
    {
        return RecipeCategoryModel::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $recipeCategory = RecipeCategoryModel::findOrFail($id);
        $recipeCategory->update($request->all());
        return $recipeCategory;
    }

    public function destroy($id)
    {
        RecipeCategoryModel::destroy($id);
        return response()->noContent();
    }
}
