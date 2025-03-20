<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostSuccessfullyTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_post_successfully()
    {
        // Crear usuario y autenticarlo
        $user = User::factory()->create();
        $this->actingAs($user);

        // Crear categorías
        $categories = Category::factory()->count(3)->create();

        // Datos del post a enviar
        $payload = [
            'title' => 'Título de prueba',
            'excerpt' => 'Extracto de prueba',
            'content' => 'Contenido del post de prueba.',
            'categories' => $categories->pluck('id')->toArray(),
            'user_id' => $user->id

        ];

        // Enviar solicitud POST
        $response = $this->postJson('/api/v1/posts', $payload);

        // Verificar que la respuesta es exitosa (201 Created)
        $response->assertStatus(201);

        // Verificar que el post existe en la base de datos
        $this->assertDatabaseHas('posts', [
            'title' => $payload['title'],
            'excerpt' => $payload['excerpt'],
            'content' => $payload['content'],
            'user_id' => $user->id,
        ]);

        // Obtener el post recién creado desde la base de datos
        $post = Post::where('title', $payload['title'])->first();

        // Verificar que las relaciones en la tabla pivote existen
        foreach ($categories as $category) {
            $this->assertDatabaseHas('category_post', [
                'post_id' => $post->id,
                'category_id' => $category->id,
            ]);
        }

        // Verificar la respuesta JSON
        $response->assertJson([
            'id' => $post->id,
            'title' => $post->title,
            'excerpt' => $post->excerpt,
            'content' => $post->content,
            'categories' => $categories->map(fn($cat) => [
                'id' => $cat->id,
                'name' => $cat->name,
            ])->toArray(),
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]
        ]);

        // Verificar estructura de la respuesta JSON
        $response->assertJsonStructure([
            'id',
            'title',
            'slug',
            'excerpt',
            'content',
            'categories' => [
                '*' => ['id', 'name']
            ],
            'user' => ['id', 'name', 'email'],
            'created_at',
            'updated_at'
        ]);
    }
}
