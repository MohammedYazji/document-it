<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/posts/{slug}', [HomeController::class, 'show'])->name('post.show');
Route::get('/u/{username}', fn () => null)->name('users.profile');

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Follow / Unfollow
    Route::post('follow', [FollowController::class, 'store'])->name('follow.store');
    Route::delete('follow', [FollowController::class, 'destroy'])->name('follow.destroy');

    // Notifications
    Route::prefix('dashboard/notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::patch('/{id}/read', [NotificationController::class, 'read'])->name('read');
        Route::patch('/{id}/unread', [NotificationController::class, 'unread'])->name('unread');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
    });

    // Post management
    Route::patch('dashboard/posts/{post}/restore', [PostController::class, 'restore'])->name('posts.restore');
    Route::delete('dashboard/posts/{post}/force-delete', [PostController::class, 'forceDelete'])->name('posts.forceDelete');
    Route::resource('dashboard/posts', PostController::class)->names([
        'index', 'create', 'store', 'show', 'edit', 'update', 'destroy',
    ]);

    // Category management
    Route::resource('dashboard/categories', CategoryController::class)->names([
        'index', 'create', 'store', 'edit', 'update', 'destroy',
    ]);
});
