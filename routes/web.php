<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

// Post Routes
Route::patch('dashboard/posts/{post}/restore', [PostController::class, 'restore'])
    ->name('posts.restore')
    ->middleware(['auth', 'verified']);
Route::delete('dashboard/posts/{post}/force-delete', [PostController::class, 'forceDelete'])
    ->name('posts.forceDelete')
    ->middleware(['auth', 'verified']);

Route::resource('dashboard/posts', PostController::class)
    ->names([
        'index'   => 'posts.index',
        'create'  => 'posts.create',
        'store'   => 'posts.store',
        'show'    => 'posts.show',
        'edit'    => 'posts.edit',
        'update'  => 'posts.update',
        'destroy' => 'posts.destroy',
    ])
    ->middleware(['auth', 'verified']);

// Category Routes
Route::resource('dashboard/categories', CategoryController::class)->names([
    'index'   => 'categories.index',
    'create'  => 'categories.create',
    'store'   => 'categories.store',
    'edit'    => 'categories.edit',
    'update'  => 'categories.update',
    'destroy' => 'categories.destroy',
]);
