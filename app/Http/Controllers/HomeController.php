<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()->published()->latest()->paginate(3);

        return view('home', compact('posts'));
    }

    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $posts = Post::query()
            ->published()
            ->whereHas('tags', fn ($q) => $q->where('tags.id', $tag->id))
            ->latest()
            ->paginate(10);

        return view('home', compact('posts', 'tag'));
    }

    public function show($slug)
    {
        $post = Post::query()->published()->where('slug', $slug)->firstOrFail();

        event('posts.view', $post);

        $relatedPosts = $post->related(sameCategory: true);

        return view('posts.show', compact('post', 'relatedPosts'));
    }
}
