<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/recipes', function () {
    return inertia::render('recipe_page');
});

Route::get('/recipes/create', function () {
    return inertia::render('recipes/create_recipe');
});
