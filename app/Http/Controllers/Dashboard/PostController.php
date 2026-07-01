<?php

namespace App\Http\Controllers\Dashboard;

use App\Actions\FileUpload;
use App\Actions\SyncTags;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $posts_all = Post::get();

        $posts = Post::with('category', 'user')
            ->select('id', 'category_id', 'title', 'slug', 'status', 'created_at', 'published_at', 'deleted_at')
            // ->addSelect(
            //     DB::raw('SELECT COUNT(+) FROM comments WHERE comments.post_id = posts.id AS comments_count')
            // )
            ->withCount('comments')
            ->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->withTrashed()
            ->latest()
            ->paginate(3);

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
            'post' => new Post,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request, PostService $postService)
    {
        $data = $request->validated();
        $tagsInput = $data['tags'] ?? null;
        unset($data['tags']);

        $data['status'] = $request->has('status') ? 'published' : 'draft';
        $data['user_id'] = $request->user()->id;

        try {
            $postService->create($data, $tagsInput);
        } catch (\RuntimeException $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $post)
    {
        $post = Post::with(['category', 'tags', 'user'])
            ->withCount('comments')
            ->findOrFail($post);

        event('posts.view', $post);

        return view('posts.show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $post = Post::with('tags')->findOrFail($id);

        return view('dashboard.posts.edit', [
            'post' => $post,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id, FileUpload $fileUpload, SyncTags $syncTags)
    {
        $post = Post::findOrFail($id);

        $data = [
            'slug' => Str::slug($request->post('title')),
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
     * Restore the specified soft-deleted resource.
     */
    public function restore(string $id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('posts.index')->with('success', 'Post restored successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        // PRG: POST Redirect GET
        return redirect()->route('posts.index')->with('success', 'Post sent to trash.');
    }

    /**
     * Permanently remove the specified soft-deleted resource from storage.
     */
    public function forceDelete(string $id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        $post->forceDelete();

        return redirect()->route('posts.index')->with('success', 'Post permanently deleted.');
    }
}
