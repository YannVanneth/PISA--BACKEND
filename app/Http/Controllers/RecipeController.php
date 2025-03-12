<?php

namespace App\Http\Controllers;

use App\Models\recipe; // Fixed model name
use Illuminate\Http\Request;

class RecipeController
{
    public function index()
    {
        return Recipe::all();
    }

    public function store(Request $request)
    {
        $recipe = new Recipe();
        $recipe->category_id = $request->category_id;
        $recipe->title_kh = $request->title_kh;
        $recipe->title_en = $request->title_en;
        $recipe->description_kh = $request->description_kh;
        $recipe->description_en = $request->description_en;
        $recipe->picture = $request->picture;
        $recipe->video = $request->video;
        $recipe->view_count = $request->view_count ?? 0; // Ensure default value

        $recipe->save(); // Fixed variable name
        return response()->json(["message" => "Recipe added successfully"], 201);
    }

    public function show(Recipe $recipe)
    {
        return $recipe; // No need to use findOrFail()
    }

    public function update(Request $request, $id)
    {
        try {
            $recipe = Recipe::findOrfail($id);
            $recipe->update([
                'category_id' => $request->category_id ?? $recipe->category_id,
                'title_kh' => $request->title_kh ?? $recipe->title_kh,
                'title_en' => $request->title_en ?? $recipe->title_en,
                'description_kh' => $request->description_kh ?? $recipe->description_kh,
                'description_en' => $request->description_en ?? $recipe->description_en,
                'picture' => $request->picture ?? $recipe->picture,
                'video' => $request->video ?? $recipe->video,
                'view_count' => $request->view_count ?? $recipe->view_count,
            ]);

            return response()->json(["message" => "Recipe updated successfully"], 200);
        } catch (\Throwable $th) { // Fixed exception class
            return response()->json([
                "message" => "Update error",
                "error" => $th->getMessage() // Fixed typo in getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        // $recipe->delete();
        // return response()->json(["message" => "Recipe deleted successfully"], 200);

        try {
            $recipe = Recipe::findOrfail($id);
            $recipe->delete();

            return response()->json([
                "message" => "Recipe deleted successfully."
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Recipe deletion failed.",
                "error" => $th->getMessage()
            ], 400);
        }
    }
}
