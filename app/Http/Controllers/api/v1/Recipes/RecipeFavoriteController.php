<?php

namespace App\Http\Controllers\api\v1\Recipes;

use App\Http\Controllers\Controller;
use App\Models\Recipes\RecipeFavoriteModel;
use Illuminate\Http\Request;

class RecipeFavoriteController extends Controller
{
    public function index()
    {
        return RecipeFavoriteModel::all();
    }

    public function store(Request $request)
    {
        return RecipeFavoriteModel::create($request->all());
    }

    public function show($id)
    {
        return RecipeFavoriteModel::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $recipeFavorite = RecipeFavoriteModel::findOrFail($id);
        $recipeFavorite->update($request->all());
        return $recipeFavorite;
    }

    public function destroy($id)
    {
        RecipeFavoriteModel::destroy($id);
        return response()->noContent();
    }
}
