<?php

use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\Dashboard\AiWriteController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/posts/{slug}', [HomeController::class, 'show'])->name('post.show');
Route::get('/tags/{tag}', [HomeController::class, 'tag'])->name('tag.show');
Route::get('/u/{username}', [ProfileController::class, 'show'])->name('users.profile');

// Google OAuth
Route::get('/auth/google', [SocialiteController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [SocialiteController::class, 'callback'])->name('google.callback');

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Follow / Unfollow
    Route::post('follow', [FollowController::class, 'store'])->name('follow.store');
    Route::delete('follow', [FollowController::class, 'destroy'])->name('follow.destroy');

    // Bookmarks
    Route::get('bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('bookmarks', [BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::delete('bookmarks', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');

    // Likes
    Route::post('likes', [LikeController::class, 'store'])->name('likes.store');
    Route::delete('likes', [LikeController::class, 'destroy'])->name('likes.destroy');

    // Settings
    Route::get('settings', [ProfileController::class, 'edit'])->name('settings');
    Route::put('settings', [ProfileController::class, 'update'])->name('settings.update');

    // Dashboard
    Route::prefix('dashboard')->group(function () {

        // User management (super-admin only)
        Route::middleware('user.type:super-admin')->prefix('admin')->name('admin.')->group(function () {
            Route::resource('users', UserController::class);
        });

        // Notifications (all authenticated users)
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [NotificationController::class, 'index'])->name('index');
            Route::patch('/{id}/read', [NotificationController::class, 'read'])->name('read');
            Route::patch('/{id}/unread', [NotificationController::class, 'unread'])->name('unread');
            Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        });

        // Posts (all authenticated users - owners can manage their own)
        Route::get('posts/ai', AiWriteController::class)->name('posts.ai');
        Route::patch('posts/{post}/restore', [PostController::class, 'restore'])->name('posts.restore');
        Route::delete('posts/{post}/force-delete', [PostController::class, 'forceDelete'])->name('posts.forceDelete');
        Route::resource('posts', PostController::class)->names([
            'index', 'create', 'store', 'show', 'edit', 'update', 'destroy',
        ]);

        // Categories (admin only)
        Route::middleware('user.type:admin,super-admin')->resource('categories', CategoryController::class)->names([
            'index', 'create', 'store', 'edit', 'update', 'destroy',
        ]);
    });
});
