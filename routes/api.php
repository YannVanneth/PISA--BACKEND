<?php

use App\Events\UserNotification;
use App\Http\Controllers\api\v1\CookingInstruction\CookingStepController;
use App\Http\Controllers\api\v1\Ingredient\IngredientController;
use App\Http\Controllers\api\v1\Recipes\RecipeCategoryController;
use App\Http\Controllers\api\v1\Recipes\RecipeFavoriteController;
use App\Http\Controllers\api\v1\Recipes\RecipeRatingController;
use App\Http\Controllers\api\v1\Recipes\RecipesController;
use App\Http\Controllers\api\v1\Search\SearchController;
use App\Http\Controllers\api\v1\User\UserCommentController;
use App\Http\Controllers\api\v1\User\UserProfileController;
use App\Http\Controllers\api\v1\WishList\WishListController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\mail\MailController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    # normal login authentication routes
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/cancelRegistration', [AuthController::class, 'cancelRegistration']);

    # Google OAuth routes
    Route::post('/google/callback', [AuthController::class, 'handleGoogleCallback']);
    Route::post('/google/logout', [AuthController::class, 'logout']);

    # Facebook OAuth routes
    Route::post('/facebook/callback', [AuthController::class, 'handleFacebookCallback']);
    Route::post('/facebook/logout', [AuthController::class, 'logout']);

    Route::get('/verifyOTP', [MailController::class, 'verifyOTP']);
    Route::get('/RegisterVerifyOTP', [MailController::class, 'RegisterMail']);

    # logout route
    Route::post('/logout', [AuthController::class, 'logout']);

    # check if user is authenticated
    Route::get('/check', [AuthController::class, 'check']);

    # broadcast auth routes
    Route::post('/broadcasting/auth', [AuthController::class, 'broadcastAuth']);
})->middleware('guest');


# API Version 1 Routes (Protected with auth:sanctum)
Route::prefix('v1')->middleware(['auth:sanctum'])->group(callback: function () {
    Route::resource('cookingSteps', CookingStepController::class);
    Route::resource('recipeCategories', RecipeCategoryController::class);
    Route::resource('recipes', RecipesController::class);
    Route::resource('ingredients', IngredientController::class);
    Route::resource('wishlists',WishlistController::class);
    Route::resource('rating',RecipeRatingController::class);

    # User Profile Routes
    Route::prefix('user-profile')->group(function (){
        Route::get('userProfile', [UserProfileController::class, 'checkExistingUser']);
        Route::get('index', [UserProfileController::class, 'index']);
        Route::get('show/{id}', [UserProfileController::class, 'show']);
        Route::post('update/{id}', [UserProfileController::class, 'update']);

    });

    //favorite -----------------------------------------------------------------------------
    Route::delete('favorite/remove', [RecipeFavoriteController::class, 'destroy']);

    Route::post('favorite/add', [RecipeFavoriteController::class, 'store']);
    Route::get('favorite/index', [RecipeFavoriteController::class, 'index']);
    Route::get('favorite/profile', [RecipeFavoriteController::class, 'getByProfile']);

    //search --------------------------------------------------------------------------------
    Route::get('search', [SearchController::class, 'index']);
    Route::get('search/ingredients', [SearchController::class, 'searchByIngredients']);
    Route::get('search/categoryies', [SearchController::class, 'searchByCategory']);
    Route::get('search/recipes', [SearchController::class, 'searchByRecipes']);

    require __DIR__ . '/comment.php';
});


Route::get('test', function (){
    event(new UserNotification("Someone replied to your comment!"
        , "@David  is react your comment"
        , "assignment"
        , "1"));

//    event(new UserNotification("From Dev Team."
//        , "We are happy to inform you that you has been the first to comment on this recipe."
//        , "assignment"
//        , "1"));


//    event(new \App\Events\UserNotification("Someone replied to your comment!", "@David react is react your comment", "assignment", "1"));
    return response()->json(['message' => 'Event has been sent']);
});
//->middleware(['auth:sanctum'])->

//require __DIR__ . '/auth.php';

