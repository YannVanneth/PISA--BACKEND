<?php

namespace App\Http\Controllers\api\v1\Ingredient;

use App\Http\Controllers\Controller;
use App\Models\Ingredients\IngredientModel;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    // Get all ingredients
    public function index()
    {
        return IngredientModel::all();
    }

    // Create a new ingredient
    public function store(Request $request)
    {
        $request->validate([
            'recipes_id' => 'required|exists:recipes,recipes_id',
            'ingredients_name_en' => 'required|string',
            'ingredients_name_km' => 'required|string',
            'ingredients_quantity' => 'required|integer',
            'ingredients_unit' => 'required|string',
            'ingredients_imageURL' => 'required|string',
        ]);

        return IngredientModel::create($request->all());
    }

    // Get a specific ingredient
    public function show($id)
    {
        return IngredientModel::findOrFail($id);
    }

    // Update an ingredient
    public function update(Request $request, $id)
    {
        $ingredient = IngredientModel::findOrFail($id);
        $ingredient->update($request->all());
        return $ingredient;
    }

    // Delete an ingredient
    public function destroy($id)
    {
        IngredientModel::destroy($id);
        return response()->noContent();
    }
}
