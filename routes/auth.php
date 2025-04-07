<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\mail\MailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});


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
