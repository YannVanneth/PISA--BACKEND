<?php

namespace App\Http\Controllers;

use App\Models\Category; 
use Illuminate\Http\Request; 

class CategoryController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Category::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'icon' => 'required|string',
            'name_kh' => 'required|string',
            'name_en' => 'required|string',
        ]);

        try {
            $category = Category::create([
                'icon' => $request->icon,
                'name_kh' => $request->name_kh,
                'name_en' => $request->name_en,
            ]);

            return response()->json([
                "message" => "Category created successfully.",
                "data" => $category
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Category creation failed.",
                "error" => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Category::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'icon' => 'sometimes|string',
            'name_kh' => 'sometimes|string',
            'name_en' => 'sometimes|string',
        ]);

        try {
            $category = Category::findOrFail($id);

            $category->update([
                'icon' => $request->icon ?? $category->icon,
                'name_kh' => $request->name_kh ?? $category->name_kh,
                'name_en' => $request->name_en ?? $category->name_en,
            ]);

            return response()->json([
                "message" => "Category updated successfully.",
                "data" => $category
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Category update failed.",
                "error" => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);

            $category->delete();

            return response()->json([
                "message" => "Category deleted successfully."
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Category deletion failed.",
                "error" => $th->getMessage()
            ], 400);
        }
    }
}