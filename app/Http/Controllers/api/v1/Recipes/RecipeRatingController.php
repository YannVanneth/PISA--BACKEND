<?php

namespace App\Http\Controllers\api\v1\Recipes;

use App\Http\Controllers\Controller;
use App\Models\Recipes\RecipeRatingModel;
use Illuminate\Http\Request;

class RecipeRatingController extends Controller
{
    public function index()
    {
        return RecipeRatingModel::all();
    }

    public function store(Request $request)
    {
        return RecipeRatingModel::create($request->all());
    }

    public function show($id)
    {
        return RecipeRatingModel::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $recipeRating = RecipeRatingModel::findOrFail($id);
        $recipeRating->update($request->all());
        return $recipeRating;
    }

    public function destroy($id)
    {
        RecipeRatingModel::destroy($id);
        return response()->noContent();
    }
}
