<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        // session-based testing di-off kan
//        $response = $this->post('/login', [
//            'email' => $user->email,
//            'password' => 'password',
//        ]);
//
//        $this->assertAuthenticated();
//        $response->assertNoContent();

        $response = $this->postJson('/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
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
                'message' => 'Login successful',
            ]);

        $this->assertNotEmpty($response->json('data.access_token'));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        // session-based testing di-off kan
//        $this->post('/login', [
//            'email' => $user->email,
//            'password' => 'wrong-password',
//        ]);
//
//        $this->assertGuest();

        $response = $this->postJson('/login', [
            'email'    => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        // session-based testing di-off kan
//        $response = $this->actingAs($user)->post('/logout');
//
//        $this->assertGuest();
//        $response->assertNoContent();

        // login & get token
        $loginResponse = $this->postJson('/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $token = $loginResponse->json('data.access_token');

        // Logout
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/logout');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Logout successful',
            ]);

        // died token
        $deadResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',  // <-- tambahkan ini
        ])->getJson('/api/user');

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id'   => $user->id,
            'tokenable_type' => User::class,
        ]);
    }
}
