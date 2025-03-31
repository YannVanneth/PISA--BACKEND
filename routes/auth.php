<?php

# Authentication routes
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
