<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query('page', 1);

        $key = "home_posts_{$page}";
        $cached = Cache::get($key);
        if ($cached) {
            class_exists(LengthAwarePaginator::class);
            $posts = unserialize($cached);
        } else {
            $posts = Post::query()->published()->latest()->paginate(3);
            Cache::put($key, serialize($posts), 300);
        }

        return view('home', compact('posts'));
    }

    public function show($slug)
    {
        $post = Cache::remember("home_post_{$slug}", 3600, function () use ($slug) {
            return Post::query()->published()->where('slug', $slug)->firstOrFail();
        });

        event('posts.view', $post);

        $relatedPosts = Cache::remember("home_post_{$slug}_related", 3600, function () use ($post) {
            return $post->related(sameCategory: true);
        });

        return view('posts.show', compact('post', 'relatedPosts'));
    }
}
