<?php

namespace Tests\Feature;

use App\Actions\FileUpload;
use App\Actions\SyncTags;
use App\Ai\Agents\SeoAgent;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Laravel\Ai\Embeddings;
use Laravel\Ai\Image;
use Tests\TestCase;

class PostCreateServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_with_valid_data(): void
    {
        Storage::fake('public');

        SeoAgent::fake();
        Image::fake();
        Embeddings::fake();

        $user = User::factory()->create();
        $category = Category::factory()->create(['parent_id' => null]);

        $service = new PostService(
            new FileUpload,
            new SyncTags,
            new SeoAgent,
        );

        $post = $service->create(
            data: [
                'user_id' => $user->id,
                'category_id' => $category->id,
                'title' => 'My First Blog Post',
                'content' => 'This is the content of my first blog post.',
                'slug' => 'my-first-blog-post-'.uniqid(),
                'status' => 'draft',
            ],
            tagsInput: 'laravel, php, testing',
        );

        $this->assertInstanceOf(Post::class, $post);
        $this->assertEquals('My First Blog Post', $post->title);
        $this->assertTrue($post->exists);
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'My First Blog Post',
            'user_id' => $user->id,
            'category_id' => $category->id,
            'status' => 'draft',
        ]);

        $post->load('tags');
        $this->assertCount(3, $post->tags);
        $this->assertEquals(['laravel', 'php', 'testing'], $post->tags->pluck('name')->toArray());
    }
}
