<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'Administrator']);
    }

    public function test_users_index_is_displayed(): void
    {
        $response = $this->actingAs($this->admin)->get('/users');
        $response->assertStatus(200);
    }

    public function test_user_create_form_is_displayed(): void
    {
        $response = $this->actingAs($this->admin)->get('/users/create');
        $response->assertStatus(200);
    }

    public function test_user_can_be_created(): void
    {
        $response = $this->actingAs($this->admin)->post('/users', [
            'name' => 'New User',
            'email' => 'new@user.com',
            'role' => 'Finance Clerk',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/users');
        $this->assertDatabaseHas('users', ['email' => 'new@user.com', 'role' => 'Finance Clerk']);
    }

    public function test_user_show_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->get("/users/{$user->id}");
        $response->assertStatus(200);
    }

    public function test_user_edit_form_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->get("/users/{$user->id}/edit");
        $response->assertStatus(200);
    }

    public function test_user_can_be_deleted(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/users/{$user->id}");

        $response->assertRedirect('/users');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_user_cannot_delete_self(): void
    {
        $response = $this->actingAs($this->admin)->delete("/users/{$this->admin->id}");

        $response->assertRedirect('/users');
        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    public function test_roles_page_is_displayed(): void
    {
        $response = $this->actingAs($this->admin)->get('/users-roles');
        $response->assertStatus(200);
    }

    public function test_audit_page_is_displayed(): void
    {
        $response = $this->actingAs($this->admin)->get('/users-audit');
        $response->assertStatus(200);
    }

    public function test_unauthorized_user_cannot_access_users(): void
    {
        $member = User::factory()->create(['role' => 'Member']);

        $response = $this->actingAs($member)->get('/users');
        $response->assertStatus(403);
    }
}
