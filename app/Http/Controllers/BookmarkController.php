<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['post_id' => 'required|int|exists:posts,id']);

        $user = $request->user();
        $postId = (int) $request->post('post_id');

        if ($user->bookmarks()->where('post_id', $postId)->exists()) {
            return redirect()->back();
        }

        $user->bookmarks()->attach($postId);

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $request->validate(['post_id' => 'required|int|exists:posts,id']);

        $request->user()->bookmarks()->detach((int) $request->post('post_id'));

        return redirect()->back();
    }
}
