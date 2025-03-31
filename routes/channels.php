<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('public', function () {
    return true;
});

Broadcast::channel('comment.{recipeId}', function () {
    return Auth::check();
});

Broadcast::channel('comment.user.{profileId}', function ($user, $userProfile) {
    return (int) $user->profile_id === (int) $userProfile->user_profile_id;
});

Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->users_id === (int) $userId;
});
