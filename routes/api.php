<?php

use App\Http\Controllers\api\v1\CookingInstruction\CookingInstructionController;
use App\Http\Controllers\api\v1\CookingInstruction\CookingStepController;
use App\Http\Controllers\api\v1\Ingredient\IngredientController;
use App\Http\Controllers\api\v1\Recipes\RecipeCategoryController;
use App\Http\Controllers\api\v1\Recipes\RecipesController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

# Authentication routes
Route::prefix('auth')->group(function () {
//    Route::post('/', [AuthController::class, 'register']);

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

# API Version 1 Routes (Protected with auth:sanctum)
Route::prefix('v1')->middleware(['auth:sanctum'])->group(function () {
    Route::resource('cookingInstructions', CookingInstructionController::class);
    Route::resource('cookingSteps', CookingStepController::class);
    Route::resource('recipeCategories', RecipeCategoryController::class);
    Route::resource('recipes', RecipesController::class);
    Route::resource('ingredients', IngredientController::class);
});
