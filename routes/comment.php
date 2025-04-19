<?php


use App\Http\Controllers\api\v1\User\UserCommentController;
use Illuminate\Support\Facades\Route;

Route::prefix('comment')->group(function () {
    Route::get('index', [UserCommentController::class, 'index']);
    Route::post('handleComment', [UserCommentController::class, 'handleComment']);
    Route::post('/reaction', [UserCommentController::class, 'handleCommentReaction']);
});
