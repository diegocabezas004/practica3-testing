<?php

namespace Tests\Feature;

use App\Models\Post;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ErrorAuthEP extends TestCase
{
    use RefreshDatabase;


    /**
     * Prueba que verifica que un usuario no autenticado 
     * recibe un error 401 al intentar crear un post.
     *
     * @return void
     */
    public function test_unauthenticated_user_cannot_access_protected_endpoint(){

        $response = $this->getJson('/api/v1/posts');

        $response->assertStatus(401);

        $response->assertJson([
            'message'=> 'Unauthenticated.'
        ]);
    }
}