<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get("/", HomeController::class)->name("home");

Route::get("/article/{id}/{slug?}", [PostController::class, "show"])->where([
    'slug' => '[a-z0-9\-]+'
]);