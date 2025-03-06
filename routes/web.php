<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipesController;

# welcome to route PISA
Route::get('/', function () {
    return view('welcome');
});

Route::get('/csrf_token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

# API Route
Route::prefix('api')->group(function () {
    Route::prefix('v1')->group(function () {

        Route::prefix('auth')->group(function () {
           Route::get('/login');
        });

        # Recipe Route
        Route::prefix('recipes')->group(function () {

           Route::get('/', [RecipesController::class, 'index']);

           Route::post('/create', [RecipesController::class, 'create']);

           Route::get('/categories', [RecipesController::class, 'indexCategory']);

           Route::get('/categories/{category_id}', [RecipesController::class, 'showByCategory']);

           Route::get('/{id}', [RecipesController::class, 'show']);

           Route::delete('/{id}', [RecipesController::class, 'destroy']);

        });
    });
});



