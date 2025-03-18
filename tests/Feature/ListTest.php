<?php

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListTest extends TestCase
{
    use RefreshDatabase;

    public function testList()
    {
        $posts = Post::factory()->count(3)->create();
        $response = $this->get('/list');



        $response->assertStatus(200);
        foreach ($posts as $post) {
            $response->assertSee($post->title);
        }
    }
}