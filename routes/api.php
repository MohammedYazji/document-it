<?php

use App\Http\Controllers\Api\V1\AccessTokenController;
use App\Http\Controllers\Api\V1\PostController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AccessTokenController::class, 'store'])->name('login');
Route::post('logout', [AccessTokenController::class, 'destroy'])->middleware('auth:sanctum')->name('logout');

Route::apiResource('posts', PostController::class);
