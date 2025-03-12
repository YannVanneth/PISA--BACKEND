<?php

namespace App\Http\Controllers;

use App\Models\ingredient;
use Illuminate\Http\Request;

class IngredientController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Ingredient::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $ingredient = Ingredient::create([
                'recipe_id' => $request->recipe_id,
                'name_kh' => $request->name_kh,
                'name_en' => $request->name_en,
                'quantity' => $request->quantity,
                'unit' => $request->unit,
                'picture' => $request->picture,
            ]);
            return response()->json([
                "message" => "Ingredient created successfully.",
                "data" => $ingredient
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Ingredient creation failed.",
                "error" => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Ingredient::findOrfail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        try {
            // Update the existing ingredient
            $ingredient->update([
                'recipe_id' => $request->recipe_id ?? $ingredient->recipe_id,
                'name_kh' => $request->name_kh ?? $ingredient->name_kh,
                'name_en' => $request->name_en ?? $ingredient->name_en,
                'quantity' => $request->quantity ?? $ingredient->quantity,
                'unit' => $request->unit ?? $ingredient->unit,
                'picture' => $request->picture ?? $ingredient->picture,
            ]);
    
            return response()->json([
                "message" => "Ingredient updated successfully.",
                "data" => $ingredient
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Ingredient update failed.",
                "error" => $th->getMessage()
            ], 400);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingredient $ingredient)
    {
        try {
            $ingredient->delete();
    
            return response()->json([
                "message" => "Ingredient deleted successfully."
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Ingredient deletion failed.",
                "error" => $th->getMessage()
            ], 400);
        }
    }
    
}
