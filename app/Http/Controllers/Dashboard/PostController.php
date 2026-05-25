<?php

namespace App\Http\Controllers\Dashboard;

use App\Actions\FileUpload;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            ->where('user_id', '=', auth()->id())
            ->get();

        $query = Post::query()
            ->where('user_id', '=', auth()->id());

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
            'post'       => new Post(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request, FileUpload $fileUpload)
    {
        $clean = $request->validated();

        $cover_image_path = $fileUpload->handle('cover_image', 'covers');

        $data = array_merge($clean , [
            'user_id'     => auth()->id(),
            'slug'        => Str::slug($request->post('title')),
            'status'      => $request->has('status') ? 'published' : 'draft',
            'cover_image' => $cover_image_path,
        ]);

        $post = Post::create($data + ['cover_image' => $cover_image_path]);

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
            'post'       => $post,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id, FileUpload $fileUpload)
    {
        $post = Post::findOrFail($id);

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

        $post->update(array_merge(
            $request->except(['_method', '_token', 'cover_image']),
            $data
        ));

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
