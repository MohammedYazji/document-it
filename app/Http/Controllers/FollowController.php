<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\FollowNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FollowController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['user_id' => 'required|int|exists:users,id']);

        $follower = $request->user();
        $user_id = (int) $request->post('user_id');

        if ($follower->id === $user_id) {
            return redirect()->back();
        }

        $alreadyFollowing = $follower->followings()->where('user_id', $user_id)->exists();

        if (! $alreadyFollowing) {
            $follower->followings()->attach($user_id, [
                'id'         => Str::uuid(),
                'created_at' => now(),
            ]);

            User::find($user_id)?->notify(new FollowNotification($follower));
        }

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $request->validate(['user_id' => 'required|int|exists:users,id']);

        $follower = $request->user();

        $follower->followings()->detach((int) $request->post('user_id'));

        return redirect()->back();
    }
}
