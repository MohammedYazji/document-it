<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->query('sort', 'recent');
        $category = $request->query('category');
        $readtime = $request->query('readtime');

        $query = Post::query()->published();

        if ($category) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $category));
        }

        if ($readtime === 'short') {
            $query->whereRaw('CEIL(LENGTH(content) / 1400) <= 5');
        } elseif ($readtime === 'long') {
            $query->whereRaw('CEIL(LENGTH(content) / 1400) >= 10');
        }

        match ($sort) {
            'popular' => $query->orderByDesc('views'),
            'trending' => $query->withCount('likedBy')->orderByDesc('liked_by_count'),
            default => $query->latest(),
        };

        $posts = $query->paginate(10)->appends($request->query());
        $categories = \App\Models\Category::orderBy('name')->get();

        return view('home', compact('posts', 'categories', 'sort', 'category', 'readtime'));
    }

    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $posts = Post::query()
            ->published()
            ->whereHas('tags', fn ($q) => $q->where('tags.id', $tag->id))
            ->latest()
            ->paginate(10);

        return view('home', [
            'posts' => $posts,
            'tag' => $tag,
            'categories' => \App\Models\Category::orderBy('name')->get(),
            'category' => null,
            'sort' => 'recent',
            'readtime' => null,
        ]);
    }

    public function show($slug)
    {
        $post = Post::query()->published()->where('slug', $slug)->firstOrFail();

        event('posts.view', $post);

        $relatedPosts = $post->related(sameCategory: true);

        return view('posts.show', compact('post', 'relatedPosts'));
    }
}
