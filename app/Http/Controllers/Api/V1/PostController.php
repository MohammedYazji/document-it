<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostJsonApiResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        return Post::published()
            ->with(
                'category:id,name',
                'user:id,name,username,avatar'
            )->paginate();

        return PostResource::collection($posts);
    }

    public function store(PostRequest $request, PostService $postService): JsonResponse
    {
        $user = Auth::guard('sanctum')->user();

        if (! $user->tokenCan('posts.create')) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        $data = $request->validated();
        $tagsInput = $data['tags'] ?? null;
        unset($data['tags']);

        $data['status'] = $request->has('status') ? 'published' : 'draft';
        $data['user_id'] = $user->id;

        try {
            $post = $postService->create($data, $tagsInput);
        } catch (\RuntimeException $e) {
            return response()->json(['status' => 'error', 'message' => 'Failed to create post: '.$e->getMessage()], 500);
        }

        return response()->json($post, 201);
    }

    public function show(Post $post): Post
    {
        if ($post->status !== PostStatus::Published) {
            return response()->json(['message' => 'Not found.'], 404);
        }

        return $post->load(
            'category:id,name',
            'user:id,name,username,avatar'
        );

        return new PostJsonApiResource($post);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(Post $post): JsonResponse
    {
        $post->delete();

        return response()->json(null, 204);
    }
}
