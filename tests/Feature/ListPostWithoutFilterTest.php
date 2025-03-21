<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ListPostsWithoutFilterTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $otherUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        
        $this->otherUser = User::factory()->create();

        Post::factory()->count(5)->create([
            'user_id' => $this->user->id,
            'title' => 'title',
            'content' => 'content'
        ]);

        Post::factory()->count(2)->create([
            'user_id' => $this->otherUser->id
        ]);
    }


    public function test_it_can_list_posts_without_filter()
    {
        $this->actingAs($this->user);
        $response = $this->getJson('/api/v1/posts');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            'data' => [
                '*' => [
                    'id', 
                    'title', 
                    'slug', 
                    'excerpt', 
                    'content', 
                    'user_id', 
                    'created_at', 
                    'updated_at'
                ]
            ]
        ]);

        $response->assertJsonCount(5, 'data');

        $responseData = $response->json('data');
        foreach ($responseData as $post) {
            $this->assertEquals($this->user->id, $post['user_id']);
        }


    }
}