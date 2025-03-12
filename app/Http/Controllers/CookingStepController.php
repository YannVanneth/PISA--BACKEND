<?php

namespace App\Http\Controllers;

use App\Models\cookingStep;
use Illuminate\Http\Request;

class CookingStepController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CookingStep::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $cookingStep = CookingStep::create([
                'recipe_id' => $request->recipe_id,
                'step_number' => $request->step_number,
                'instruction_kh' => $request->instruction_kh,
                'instruction_en' => $request->instruction_en,
            ]);
            return response()->json([
                "message" => "Cooking Step created successfully.",
                "data" => $cookingStep
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Cooking Step creation failed.",
                "error" => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return CookingStep::findOrfail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CookingStep $cookingStep)
    {
        try {
            $cookingStep->update([
                'recipe_id' => $request->recipe_id ?? cookingStep->recipe_id,
                'step_number' => $request->step_number ?? cookingStep->step_number,
                'instruction_kh' => $request->instruction_kh ?? cookingStep->instruction_kh,
                'instruction_en' => $request->instruction_en ?? cookingStep->instruction_en,
            ]);
            return response()->json([
                "message" => "Cooking Step updated successfully.",
                "data" => $cookingStep
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Cooking Step update failed.",
                "error" => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CookingStep $cookingStep)
    {
        try {
            $cookingStep->delete();
    
            return response()->json([
                "message" => "Cooking step deleted successfully."
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Cooking step deletion failed.",
                "error" => $th->getMessage()
            ], 400);
        }
    }
}
