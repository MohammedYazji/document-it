<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $posts = \App\Models\Post::query()->published()->latest()->paginate(3);

        return view('home', compact('posts'));
    }

    public function show($slug)
    {
        $post = \App\Models\Post::query()->published()->where('slug', $slug)->firstOrFail();

        event('posts.view', $post);

        return view('posts.show', compact('post'));
    }
}
