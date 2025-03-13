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
        try{
            $request->validate([
                'recipes_id' => 'required|exists:recipes,recipes_id',
                'ingredients_name_en' => 'required|string',
                'ingredients_name_km' => 'required|string',
                'ingredients_quantity' => 'required|integer',
                'ingredients_unit' => 'required|string',
                'ingredients_imageURL' => 'required|string',
            ]);

            return IngredientModel::create($request->all());
        }catch (\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }

    }

    // Get a specific ingredient
    public function show($ingredients_id)
    {
        try{
            $ingredients_found = IngredientModel::find($ingredients_id);

            if($ingredients_found){
                return $ingredients_found;
            }

            return response()->json(['message' => 'Ingredient not found'], 404);
        }catch (\Exception $exception){
            return response()->json(['message' => $exception->getMessage()], 500);
        }

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
