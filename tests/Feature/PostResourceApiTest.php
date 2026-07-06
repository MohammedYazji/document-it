<?php

namespace Tests\Feature;

use App\Ai\Agents\SeoAgent;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Ai\Embeddings;
use Laravel\Ai\Image;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostResourceApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected Category $category;

    protected Post $post;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        SeoAgent::fake();
        Image::fake();
        Embeddings::fake();

        $this->user = User::factory()->create();
        $this->category = Category::factory()->create(['parent_id' => null]);
        $this->post = Post::factory()->published()->create([
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
        ]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_post_can_be_retrieved(): void
    {
        $response = $this->get('/api/v1/posts');

        $response->assertStatus(200);
        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['data', 'links', 'meta']);
            $json->has('data.0', function (AssertableJson $json) {
                $json->hasAll(['id', 'title', 'content', 'cover_url', 'status', 'published_at', 'category', 'author']);
                $json->has('status', fn (AssertableJson $json) => $json->hasAll(['name', 'label', 'color']));
                $json->has('category', fn (AssertableJson $json) => $json->hasAll(['id', 'name']));
                $json->has('author', fn (AssertableJson $json) => $json->hasAll(['id', 'username', 'name', 'avatar_url']));
            });
        });
    }

    public function test_post_can_be_created_by_user(): void
    {
        Sanctum::actingAs($this->user, ['posts.create']);

        // if we use just post without json and fail will not redirect us
        // but always return json 401 not auth instead of redirect us into login page
        $response = $this->postJson('/api/v1/posts', [
            'title' => 'Created by user',
            'content' => 'Content created via API.',
            'tags' => 'api, test',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', [
            'title' => 'Created by user',
            'user_id' => $this->user->id,
            'status' => 'draft',
        ]);
    }
}
