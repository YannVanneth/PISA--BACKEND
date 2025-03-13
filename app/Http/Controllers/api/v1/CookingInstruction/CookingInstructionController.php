<?php

namespace App\Http\Controllers\api\v1\CookingInstruction;

use App\Http\Controllers\Controller;
use App\Models\CookingInstruction\CookingInstructionModel;
use Illuminate\Http\Request;

class CookingInstructionController extends Controller
{
    public function index()
    {
        return CookingInstructionModel::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'recipes_id' => 'required|exists:recipes,recipes_id',
        ]);

        return CookingInstructionModel::create($request->all());
    }

    public function show($id)
    {
        return CookingInstructionModel::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $cookingInstruction = CookingInstructionModel::findOrFail($id);
        $cookingInstruction->update($request->all());
        return $cookingInstruction;
    }

    public function destroy($id)
    {
        CookingInstructionModel::destroy($id);
        return response()->noContent();
    }
}
