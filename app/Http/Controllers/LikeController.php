<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['post_id' => 'required|int|exists:posts,id']);

        $user = $request->user();
        $postId = (int) $request->post('post_id');

        if ($user->likes()->where('post_id', $postId)->exists()) {
            return redirect()->back();
        }

        $user->likes()->attach($postId);

        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $request->validate(['post_id' => 'required|int|exists:posts,id']);

        $request->user()->likes()->detach((int) $request->post('post_id'));

        return redirect()->back();
    }
}
