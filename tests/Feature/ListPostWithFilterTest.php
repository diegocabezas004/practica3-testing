<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListPostWithFilterTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        Post::factory()->count(3)->create([
            'user_id' => $this->user->id,
            'title' => 'title',
            'content' => 'content'
        ]);

        Post::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'title julito',
            'content' => 'content'
        ]);

        Post::factory()->create([
            'user_id' => $this->user->id,
            'title' => 'title',
            'content' => 'content julio'
        ]);
    }

    /** @test */
    public function user_can_list_their_posts_with_search_filter()
    {
        $this->actingAs($this->user);

        $response = $this->getJson('/api/v1/posts?search=julito');

        $response->assertStatus(200);
        
        $response->assertJsonStructure([
            'status',
            'data' => [
                '*' => [
                    'id', 'title', 'slug', 'excerpt', 'content', 'user_id', 'created_at', 'updated_at'
                ]
            ],
                'meta' => [
            'current_page',
            'from',
            'last_page',
            'path',
            'per_page',
            'to',
            'total',
        ]
        ]);

        $response->assertJsonCount(1, 'data');
        $responseData = $response->json('data');
        $this->assertEquals('title julito', $responseData[0]['title']);

        // Test de búsqueda por contenido
        $response = $this->getJson('/api/v1/posts?search=julio');
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        $responseData = $response->json('data');
        $this->assertEquals('content julio', $responseData[0]['content']);
    }
}