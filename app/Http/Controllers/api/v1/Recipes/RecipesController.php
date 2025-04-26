<?php

namespace App\Http\Controllers\api\v1\Recipes;

use App\Http\Controllers\Controller;
use App\Http\Resources\api\v1\RecipesResource;
use App\Models\Recipes\RecipeModel;
use App\Models\User\UserViewRecipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RecipesController extends Controller
{

    /*
     * View recipe by category
     * */

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = (int)$request->get('page', 1);
        $perPage = (int)$request->get('per_page', 10);
        $category = $request->get('category_id', null);

        $data = RecipeModel::paginate($perPage,['*'], 'page', $page);

        if($data->isEmpty()){
            return response()->json([
                'message' => 'No recipes found',
                'data' => RecipesResource::collection($data)
            ], 404);
        }

        if($category != null){

            # check if category is a number
            if(!is_numeric($category)){
                return response()->json([
                    'message' => 'Category ID must be a number'
                ], 422);
            }

            $temp = RecipeModel::where('recipe_categories_id', $category)
                ->paginate($perPage,['*'], 'page', $page);

            if($temp->isEmpty()){
                return response()->json([
                    'message' => 'No recipes found',
                    'data' => RecipesResource::collection($data)
                ], 404);
            }

            $data = $temp;
        }

        $data = RecipesResource::collection($data);

        return RecipesResource::collection($data)->additional([
            'meta' => [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
            ]
        ]);
    }

    public function UserViewing(Request $request)
    {
        try {
            $request->validate([
                'recipes_id' => 'required|integer',
            ]);

            $found = RecipeModel::find($request->recipes_id);

            if (!$found) {
                return response()->json([
                    'message' => 'Recipe not found'
                ], 404);
            }

            $view = UserViewRecipe::updateOrCreate(
                [
                    'user_profile_id' => $request->user()->user_profile_id,
                    'recipe_id' => $request->recipes_id,
                ]
            );

            if ($view->wasRecentlyCreated) {
                $found->increment('view_counts');
            }

            return response()->json([
                'message' => 'View counts updated successfully',
                'data' => $found
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : JsonResponse
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
                RecipeModel::create($validatedData);

                return response()->json([
                    'data' => $validatedData,
                ], 200);
            }

            # insert to database
            RecipeModel::create($validatedData);

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
        $data = RecipeModel::query()->where('recipes_id', $id)->first();

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

                $found = RecipeModel::query()->find($id);

                if($found != null){
                    RecipeModel::query()->updateOrCreate(['recipes_id' => $id], $validatedData);
                }


            }
            else{
                $found = RecipeModel::query()->find($id);

                if($found != null){
                    RecipeModel::query()->updateOrCreate(['recipes_id' => $id], $validatedData);
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
        $found = RecipeModel::query()->find($id);

        if($found != null){
            RecipeModel::query()->where('recipes_id', $id)->delete();
            return response()->json(["message" => "Recipes updated successfully"],200);
        }
       return response()->json(['message' => 'Recipes not found!'], 404);

    }
}
