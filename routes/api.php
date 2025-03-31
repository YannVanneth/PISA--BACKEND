<?php

use App\Http\Controllers\api\v1\CookingInstruction\CookingInstructionController;
use App\Http\Controllers\api\v1\CookingInstruction\CookingStepController;
use App\Http\Controllers\api\v1\Ingredient\IngredientController;
use App\Http\Controllers\api\v1\Recipes\RecipeCategoryController;
use App\Http\Controllers\api\v1\Recipes\RecipeFavoriteController;
use App\Http\Controllers\api\v1\Recipes\RecipesController;
use App\Http\Controllers\api\v1\Search\SearchController;
use App\Http\Controllers\api\v1\User\UserCommentController;
use App\Http\Controllers\api\v1\User\UserProfileController;
use App\Http\Controllers\api\v1\WishList\WishListController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\mail\MailController;
use Illuminate\Support\Facades\Route;


# API Version 1 Routes (Protected with auth:sanctum)
Route::prefix('v1')->group(callback: function () {
    Route::resource('cookingInstructions', CookingInstructionController::class);
    Route::resource('cookingSteps', CookingStepController::class);
    Route::resource('recipeCategories', RecipeCategoryController::class);
    Route::resource('recipes', RecipesController::class);
    Route::resource('ingredients', IngredientController::class);
    Route::resource('wishlists',WishlistController::class);

    # User Profile Routes
    Route::prefix('user-profile')->group(function (){
        Route::get('userProfile', [UserProfileController::class, 'checkExistingUser']);
        Route::get('index', [UserProfileController::class, 'index']);
        Route::get('show/{id}', [UserProfileController::class, 'show']);
        Route::post('update/{id}', [UserProfileController::class, 'update']);

    });
  
    //favorite -----------------------------------------------------------------------------
    Route::resource('favorite',RecipeFavoriteController::class);
    Route::delete('favorite/remove', [RecipeFavoriteController::class, 'destroy']);
  
    //search --------------------------------------------------------------------------------
    Route::get('search', [SearchController::class, 'index']);
    Route::get('search/ingredients', [SearchController::class, 'searchByIngredients']);
    Route::get('search/categoryies', [SearchController::class, 'searchByCategory']);
    Route::get('search/recipes', [SearchController::class, 'searchByRecipes']);

    # User Comment Routes
    Route::prefix('comment')->group(callback: function () {
        Route::post('handleComment', [UserCommentController::class, 'handleComment']);
        Route::post('handleCommentReply', [UserCommentController::class, 'handleCommentReply']);
        Route::get('index', [UserCommentController::class, 'index']);
    });
});


Route::get('test', function (){
    event(new \App\Events\UserNotification("welcome", "hello from server", "assignment", "1"));
    return response()->json(['message' => 'Event has been sent']);
});
//->middleware(['auth:sanctum'])->

require __DIR__ . '/auth.php';
