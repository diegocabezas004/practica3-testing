<?php

use App\Models\User;
use App\Models\Category;

beforeEach(function () {
    // Crear un usuario para las pruebas
    $this->user = User::factory()->create();
    
    // Autenticar al usuario
    $this->actingAs($this->user);
    
    // Crear algunas categorías para las pruebas
    Category::factory()->create(['name' => 'noticias']);
    Category::factory()->create(['name' => 'tecnología']);
    Category::factory()->create(['name' => 'demo']);
});

test('error de validación al crear post por falta de datos requeridos', function () {
    $postData = [
        'excerpt' => 'Lorem ipsum sit amet',
        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        'categories' => [1,3]
    ];

    $response = $this->postJson('/api/v1/posts', $postData);

    $response->assertStatus(422);
    
    $response->assertJsonValidationErrors(['title']);
    
    $postData = [
        'title' => 'Mi nueva publicación',
        'excerpt' => 'Lorem ipsum sit amet',
        'categories' => [1,3]
    ];

    $response = $this->postJson('/api/v1/posts', $postData);
    
    $response->assertStatus(422);
    
    $response->assertJsonValidationErrors(['content']);
    
    $postData = [
        'title' => 'Mi nueva publicación',
        'excerpt' => 'Lorem ipsum sit amet',
        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
    ];

    $response = $this->postJson('/api/v1/posts', $postData);
    
    $response->assertStatus(422);
    
    $response->assertJsonValidationErrors(['categories']);
});