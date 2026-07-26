<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_displayed(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('password'),
            'role' => 'Administrator',
        ]);

        $response = $this->post('/', [
            'email' => 'test@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    public function test_user_cannot_login_with_wrong_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/', [
            'email' => 'test@test.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'new@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'Member',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', ['email' => 'new@test.com']);
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_guest_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/');
    }
}
