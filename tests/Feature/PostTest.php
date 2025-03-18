<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_it_can_create_a_post_successfully()
    {

        $user = User::factory()->create();
        $this->actingAs(user: $user);
        $categories = Category::factory()->count(3)->create();

        $response = $this->postJson('/api/v1/posts', [
            'title'=>'title',
            'excerpt'=>'excerpt',
            'content'=>'content',
            'categories'=> $categories->pluck('id')->toArray(),
        ]);

        $response-> assertStatus(200);

        $response->assertJson([
            'title' => 'Mi nueva publicación',
            'excerpt' => 'Lorem ipsum sit amet',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
            'categories' => [
                [
                    'id' => $categories[0]->id,
                    'name' => $categories[0]->name,
                ]
            ],
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);
        
        $response->assertJsonStructure([
            'id', 'title', 'slug', 'excerpt', 'content',
            'categories' => [
                '*' => ['id', 'name']
            ],
            'user' => ['id', 'name', 'email'],
            'created_at', 'updated_at'
        ]);
    }
}
