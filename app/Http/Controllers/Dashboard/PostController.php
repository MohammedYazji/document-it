<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');

        $posts_all = Post::query()
            ->where('user_id', '=', 1) // TODO: get from auth()->id()
            ->get();

        $query = Post::query()
            ->where('user_id', '=', 1); // TODO: get from auth()->id()

        if ($status !== 'all') {
            $query->where('status', '=', $status);
        }

        $posts = $query->latest()->get();

        return view('dashboard.posts.index', [
            'posts' => $posts,
            'posts_all' => $posts_all,
            'status' => $status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.posts.create', [
            'post' => new Post(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // cause we still not have auth user so merge fake id with the request
        $request->merge([
            'user_id' => 1, // TODO: get from auth()->id()
            'slug' => Str::slug($request->post('title')),
            'status' => $request->has('status') ? 'published' : 'draft',
        ]);

        $post = Post::create($request->all());

        // PRG: POST Redirect GET
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $post = Post::findOrFail($id);

        return view('dashboard.posts.show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $post = Post::findOrFail($id);

        return view('dashboard.posts.edit', [
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        $request->merge([
            'slug' => Str::slug($request->post('title')),
            'status' => $request->has('status') ? 'published' : 'draft',
        ]);

        $post->update($request->except([
            '_method',
            '_token',
        ]));

        // PRG: POST Redirect GET
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Post::destroy($id);

        // PRG: POST Redirect GET
        return redirect()->route('posts.index');
    }
}