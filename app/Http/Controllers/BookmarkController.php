<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function index(Request $request)
    {
        $bookmarks = $request->user()->bookmarks()
            ->with(['category', 'user'])
            ->withCount('comments')
            ->latest('bookmarks.created_at')
            ->paginate(10);

        return view('dashboard.bookmarks', compact('bookmarks'));
    }

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
