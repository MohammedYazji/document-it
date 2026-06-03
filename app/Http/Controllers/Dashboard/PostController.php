<?php

namespace App\Http\Controllers\Dashboard;

use App\Actions\FileUpload;
use App\Actions\SyncTags;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');

        $user = Auth::user();

        $posts_all = $user->posts()->get();

        $posts = $user->posts()
            ->with('category', 'user')
            ->select('id', 'category_id', 'title', 'slug', 'status', 'created_at', 'published_at')
            // ->addSelect(
            //     DB::raw('SELECT COUNT(+) FROM comments WHERE comments.post_id = posts.id AS comments_count')
            // )
            ->withCount('comments')
            ->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->latest()
            ->get();

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
            'post'       => new Post(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request, FileUpload $fileUpload, SyncTags $syncTags)
    {
        $clean = $request->validated();
        $tagsInput = $clean['tags'] ?? null;
        unset($clean['tags']);

        $cover_image_path = $fileUpload->handle('cover_image', 'covers');

        DB::transaction(function () use ($clean, $request, $cover_image_path, $tagsInput, $syncTags) {
            $post = Auth::user()->posts()->create(array_merge($clean, [
                'slug'        => Str::slug($request->post('title')),
                'status'      => $request->has('status') ? 'published' : 'draft',
                'cover_image' => $cover_image_path,
            ]));

            $syncTags->handle($post, $tagsInput);
        });

        // PRG: POST Redirect GET
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $post)
    {
        $post = Auth::user()->posts()
            ->with(['category', 'tags', 'user'])
            ->withCount('comments')
            ->findOrFail($post);

        return view('dashboard.posts.show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $post = Auth::user()->posts()->with('tags')->findOrFail($id);

        return view('dashboard.posts.edit', [
            'post'       => $post,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id, FileUpload $fileUpload, SyncTags $syncTags)
    {
        $post = Auth::user()->posts()->findOrFail($id);

        $data = [
            'slug'   => Str::slug($request->post('title')),
            'status' => $request->has('status') ? 'published' : 'draft',
        ];

        // Handle new cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old image if it exists
            if ($post->cover_image) {
                Storage::disk('public')->delete($post->cover_image);
            }
            $data['cover_image'] = $fileUpload->handle('cover_image', 'covers');
        }

        DB::transaction(function () use ($post, $request, $data, $syncTags) {
            $post->update(array_merge(
                $request->except(['_method', '_token', 'cover_image', 'tags']),
                $data
            ));

            $syncTags->handle($post, $request->validated('tags'));
        });

        // PRG: POST Redirect GET
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Post::destroy($id);
        $post = Post::findOrFail($id);
        $post->delete();

        if ($post->cover_image) {
            Storage::disk('public')->delete($post->cover_image);
        }

        // PRG: POST Redirect GET
        return redirect()->route('posts.index');
    }
}
