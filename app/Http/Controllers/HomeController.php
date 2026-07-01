<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()->published()->latest()->paginate(3);

        return view('home', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::query()->published()->where('slug', $slug)->firstOrFail();

        event('posts.view', $post);

        $relatedPosts = $post->related(sameCategory: true);

        return view('posts.show', compact('post', 'relatedPosts'));
    }
}
