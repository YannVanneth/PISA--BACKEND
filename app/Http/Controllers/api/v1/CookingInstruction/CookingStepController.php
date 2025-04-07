<?php

namespace App\Http\Controllers\api\v1\CookingInstruction;

use App\Http\Controllers\Controller;
use App\Models\CookingInstruction\CookingStepModel;
use Illuminate\Http\Request;

class CookingStepController extends Controller
{
    public function index()
    {
        return CookingStepModel::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipes_id' => 'required|exists:recipes,recipes_id',
            'steps_number' => 'required|integer',
            'cooking_instruction_en' => 'required|string',
            'cooking_instruction_km' => 'required|string',
        ]);

        $cookingStep = CookingStepModel::create($request->all());
        return new CookingStepModel($cookingStep);
    }

    public function show($id)
    {
        return CookingStepModel::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $cookingStep = CookingStepModel::findOrFail($id);
        $cookingStep->update($request->all());
        return $cookingStep;
    }

    public function destroy($id)
    {
        CookingStepModel::destroy($id);
        return response()->noContent();
    }
}
