<?php

use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

// Post Controllers
Route::resource("dashboard/posts", PostController::class)->names([
    "index"=> "posts.index",
]);
