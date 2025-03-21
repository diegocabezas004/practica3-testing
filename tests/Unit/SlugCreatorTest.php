<?php

use App\Models\Post;
use App\Services\SlugCreator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SlugCreatorTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_it_can_create_a_slug()
    {
        $slug = SlugCreator::createSlug('This is a title');
        $this->assertEquals('this-is-a-title', $slug);
    }

    public function test_it_can_create_a_unique_slug()
    {

        Post::factory()->create(['slug' => 'this-is-a-title']);
        
        $slug = SlugCreator::createSlug('This is a title');
        $this->assertEquals('this-is-a-title-1', $slug);
    }

    public function test_it_can_create_a_unique_slug_with_multiple_same_titles()
    {

        Post::factory()->create(['slug' => 'this-is-a-title']);
        Post::factory()->create(['slug' => 'this-is-a-title-1']);
        
        $slug = SlugCreator::createSlug('This is a title');
        $this->assertEquals('this-is-a-title-2', $slug);
    }
}