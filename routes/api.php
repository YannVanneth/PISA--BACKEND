<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\CookingStepController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

Route::apiResource('categories', CategoryController::class);
// Route::get('/categories', [CategoryController::class, 'index']);
// Route::post('/categories', [CategoryController::class, 'store']);
// Route::get('/categories/{id}', [CategoryController::class, 'show']);
// Route::put('/categories/{id}', [CategoryController::class, 'update']);
// Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

Route::apiResource('recipes', RecipeController::class);
Route::apiResource('ingredients', IngredientController::class);
Route::apiResource('cooking_steps', CookingStepController::class);
Route::apiResource('profiles', ProfileController::class);
Route::apiResource('users', UserController::class);