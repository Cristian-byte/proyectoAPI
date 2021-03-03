<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store()
    {
        // $this->withoutExceptionHandling();
        $response = $this->json('POST', '/api/posts', [
            'title' => 'El post de prueba'
        ]);

        $response->assertJsonStructure(['id', 'title', 'created_at', 'updated_at'])
            ->assertJson(['title' => 'El post de prueba'])
            ->assertStatus(201);

        $this->assertDatabaseHas('posts', ['title' => 'El post de prueba']);
    }

    public function test_validate_title()
    {

        $response = $this->json('POST', '/api/posts', [
            'title' => ''
        ]);

        // estatus HTT 422
        $response->assertStatus(422)
            ->assertJsonValidationErrors('title');

    }
}
