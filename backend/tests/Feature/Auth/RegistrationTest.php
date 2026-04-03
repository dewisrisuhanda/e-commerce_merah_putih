<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_can_register(): void
    {

        // session-based testing di-off kan
//        $response = $this->post('/register', [
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//            'password' => 'password',
//            'password_confirmation' => 'password',
//        ]);
//
//        $this->assertAuthenticated();
//        $response->assertNoContent();

        $response = $this->postJson('/register', [
            'name'                  => 'Test User',
            'email'                 => 'test@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'access_token',
                    'token_type',
                    'user',
                ]
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Registration successful',
            ])
            ->assertStatus(201);

        $this->assertNotEmpty($response->json('data.access_token'));
    }
}
