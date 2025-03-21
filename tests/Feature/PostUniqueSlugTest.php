<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class UniqueSlugTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_post_successfully_if_slug_repeated()
    {
        $user = User::factory()->create();
        $this->actingAs(user: $user);

        $categories = Category::factory()->count(3)->create();

        $firstData = [
            'title' => 'title',
            'excerpt' => 'excerpt',
            'content' => 'content',
            'categories' => $categories->pluck('id')->toArray(),
        ];

        $firstPost = $this->postJson('/api/v1/posts', $firstData);

        $firstPost->assertStatus(201);
        $firstPost->assertJson([
            'title' => 'title',
            'slug' => 'title'
        ]);

        $secondData = [
            'title' => 'title',
            'excerpt' => 'excerpt',
            'content' => 'content',
            'categories' => $categories->pluck('id')->toArray(),
        ];

        $secondPost = $this->postJson('/api/v1/posts', $secondData);

        $secondPost->assertStatus(201);

        $this->assertNotEquals(
            $firstPost->json('slug'),
            $secondPost->json('slug')
        );

        $this->assertStringStartsWith('title', $secondPost->json('slug'));

        $this->assertDatabaseCount('posts', 2);
        $this->assertDatabaseHas('posts', [
        'title' => 'title',
        'slug' => 'title'
        ]); 

        $this->assertDatabaseHas('posts', [
            'title' => 'title',
            'slug' => 'title-1'
        ]);
    }

}