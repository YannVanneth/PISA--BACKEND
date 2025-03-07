<?php

use Illuminate\Support\Facades\Route;

# Welcome Route
Route::get('/', function () {
    return response()->json(['message' => 'Welcome to PISA API']);
});

require  __DIR__ . '/api.php';
