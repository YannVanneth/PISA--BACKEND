<?php

use App\Http\Controllers\api\v1\CookingInstruction\CookingInstructionController;
use App\Http\Controllers\api\v1\CookingInstruction\CookingStepController;
use App\Http\Controllers\api\v1\Ingredient\IngredientController;
use App\Http\Controllers\api\v1\Recipes\RecipeCategoryController;
use App\Http\Controllers\api\v1\Recipes\RecipesController;
use App\Http\Controllers\api\v1\Search\SearchController;
use App\Http\Controllers\api\v1\User\UserProfileController;
use App\Http\Controllers\api\v1\WishList\WishListController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\mail\MailController;
use Illuminate\Support\Facades\Route;

# Authentication routes
Route::prefix('auth')->group(function () {

    # normal login authentication routes
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    # Google OAuth routes

    Route::post('/google/callback', [AuthController::class, 'handleGoogleCallback']);
    Route::post('/google/logout', [AuthController::class, 'logout']);

    # Facebook OAuth routes

    Route::post('/facebook/callback', [AuthController::class, 'handleFacebookCallback']);
    Route::post('/facebook/logout', [AuthController::class, 'logout']);


    Route::post('/verifyOTP', [MailController::class, 'verifyOTP']);
    Route::post('/RegisterVerifyOTP', [MailController::class, 'RegisterMail']);



});

# API Version 1 Routes (Protected with auth:sanctum)
Route::prefix('v1')->group(callback: function () {
    Route::resource('cookingInstructions', CookingInstructionController::class);
    Route::resource('cookingSteps', CookingStepController::class);
    Route::resource('recipeCategories', RecipeCategoryController::class);
    Route::resource('recipes', RecipesController::class);
    Route::resource('ingredients', IngredientController::class);
    Route::resource('wishlists',WishlistController::class);
    Route::resource('userProfile', UserProfileController::class);


    Route::get('search', [SearchController::class, 'index']);
});

//->middleware(['auth:sanctum'])->
