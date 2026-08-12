<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function edit()
    {
        return view('settings', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'username']);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if (filled($validated['password'] ?? null)) {
            $data['password'] = bcrypt($validated['password']);
        }

        $user->update($data);

        return redirect()->route('settings')->with('success', 'Settings updated successfully.');
    }
}
