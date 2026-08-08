<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(string $username)
    {
        $user = User::where('username', $username)
            ->withCount(['posts', 'followers', 'followings'])
            ->firstOrFail();

        $posts = $user->posts()
            ->published()
            ->latest()
            ->paginate(10);

        $isFollowing = false;
        if (auth()->check()) {
            $isFollowing = auth()->user()->followings()->where('user_id', $user->id)->exists();
        }

        return view('profile', compact('user', 'posts', 'isFollowing'));
    }
}
