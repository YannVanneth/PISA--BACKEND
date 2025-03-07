<?php

use App\Http\Controllers\api\v1\CookingInstruction\CookingInstructionController;
use App\Http\Controllers\api\v1\CookingInstruction\CookingStepController;
use App\Http\Controllers\api\v1\Ingredient\IngredientController;
use App\Http\Controllers\api\v1\Recipes\RecipeCategoryController;
use App\Http\Controllers\RecipesController;
use Illuminate\Support\Facades\Route;

// Apply 'auth:api' middleware to all routes
Route::middleware('auth:api')->group(function () {

    // Cooking Instructions Routes
    Route::prefix('cooking-instructions')->group(function () {
        Route::get('/', [CookingInstructionController::class, 'index']);
        Route::post('/', [CookingInstructionController::class, 'store']);
        Route::get('/{id}', [CookingInstructionController::class, 'show']);
        Route::put('/{id}', [CookingInstructionController::class, 'update']);
        Route::delete('/{id}', [CookingInstructionController::class, 'destroy']);
    });

    // Cooking Steps Routes
    Route::prefix('cooking-steps')->group(function () {
        Route::get('/', [CookingStepController::class, 'index']);
        Route::post('/', [CookingStepController::class, 'store']);
        Route::get('/{id}', [CookingStepController::class, 'show']);
        Route::put('/{id}', [CookingStepController::class, 'update']);
        Route::delete('/{id}', [CookingStepController::class, 'destroy']);
    });

    // Recipe Categories Routes
    Route::prefix('recipe-categories')->group(function () {
        Route::get('/', [RecipeCategoryController::class, 'index']);
        Route::post('/', [RecipeCategoryController::class, 'store']);
        Route::get('/{id}', [RecipeCategoryController::class, 'show']);
        Route::put('/{id}', [RecipeCategoryController::class, 'update']);
        Route::delete('/{id}', [RecipeCategoryController::class, 'destroy']);
    });

    // Recipes Routes
    Route::prefix('recipes')->group(function () {
        Route::get('/', [RecipesController::class, 'index']);
        Route::post('/', [RecipesController::class, 'store']);
        Route::get('/{id}', [RecipesController::class, 'show']);
        Route::put('/{id}', [RecipesController::class, 'update']);
        Route::delete('/{id}', [RecipesController::class, 'destroy']);
    });

    // Ingredients Routes
    Route::prefix('ingredients')->group(function () {
        Route::get('/', [IngredientController::class, 'index']);
        Route::post('/', [IngredientController::class, 'store']);
        Route::get('/{id}', [IngredientController::class, 'show']);
        Route::put('/{id}', [IngredientController::class, 'update']);
        Route::delete('/{id}', [IngredientController::class, 'destroy']);
    });

});
