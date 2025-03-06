<?php

namespace App\Http\Controllers;

use App\Models\RecipeCategory;
use App\Models\RecipesModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RecipesController extends Controller
{

    /*
     * View recipe by category
     * */

    public function showByCategory(string $category_id) : JsonResponse
    {
        $category = RecipesModel::query()->where('recipe_categories_id', $category_id);

        if($category->count() > 0){
            return response()->json($category->get());
        }
        return response()->json(['message' => 'Category not found'], 404);
    }

    public function indexCategory() : JsonResponse
    {
        return response()->json(RecipeCategory::all());
    }


    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        return response()->json(RecipesModel::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request) : JsonResponse
    {
        try {

            $validatedData = $request->validate([
                'recipes_title_km' => 'string|required|max:255',
                'recipes_title_en' => 'string|required|max:255',
                'recipes_description_km' => 'nullable|string',
                'recipes_description_en' => 'nullable|string',
                'recipes_image' => 'nullable|string|max:255',
                'recipes_created_by' => 'nullable|string|max:255',
                'view_counts' => 'integer|required',
                'durations' => 'integer|required',
                'files' => 'nullable|array',
                'files.*' => 'file|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $fileData = [];

            if ($request->hasFile('files'))
            {
                $files = $request->file('files');

                foreach ($files as $file)
                {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('uploads', $fileName, 'public');

                    $fileData[] = [
                        'name' => $fileName,
                        'size' => $file->getSize(),
                        'mime' => $file->getMimeType(),
                    ];
                }

                $validatedData['files'] = $fileData;
                # insert to database
                RecipesModel::create($validatedData);

                return response()->json([
                    'data' => $validatedData,
                ], 200);
            }

            # insert to database
            RecipesModel::create($validatedData);

            return response()->json($validatedData, 200);

        } catch (ValidationException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'errors' => $exception->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) : JsonResponse
    {
        $data = RecipesModel::query()->where('recipes_id', $id)->first();

        if($data != null){
            return response()->json($data);
        }

        return response()->json(['message' => 'Recipe not found!'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) : JsonResponse
    {
        try{
            $validatedData = $request->validate([
                'recipes_title_km' => 'string|max:255',
                'recipes_title_en' => 'string|max:255',
                'recipes_description_km' => 'string',
                'recipes_description_en' => 'string',
                'recipes_image' => 'string|max:255',
                'recipes_created_by' => 'string|max:255',
                'view_counts' => 'integer',
                'durations' => 'integer',
                'files' => 'array|file|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $fileData = [];

            if ($request->hasFile('files'))
            {
                $files = $request->file('files');

                foreach ($files as $file)
                {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('uploads', $fileName, 'public');

                    $fileData[] = [
                        'name' => $fileName,
                        'size' => $file->getSize(),
                        'mime' => $file->getMimeType(),
                    ];
                }

                $validatedData['files'] = $fileData;

                $found = RecipesModel::query()->find($id);

                if($found != null){
                    RecipesModel::query()->updateOrCreate(['recipes_id' => $id], $validatedData);
                }


            }
            else{
                $found = RecipesModel::query()->find($id);

                if($found != null){
                    RecipesModel::query()->updateOrCreate(['recipes_id' => $id], $validatedData);
                }
            }

            return response()->json(
                ["message" => "Recipes updated successfully"]
            );
        }catch (ValidationException $exception){
            return response()->json([
              'message' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : JsonResponse
    {
        $found = RecipesModel::query()->find($id);

        if($found != null){
            RecipesModel::query()->where('recipes_id', $id)->delete();
            return response()->json(["message" => "Recipes updated successfully"],200);
        }
       return response()->json(['message' => 'Recipes not found!'], 404);

    }
}
