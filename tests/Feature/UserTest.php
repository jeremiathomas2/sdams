<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    public function test_user_can_be_created_with_linked_member(): void
    {
        $linkedMember = Member::factory()->create();

        $response = $this->actingAs($this->admin)->post('/users', [
            'name' => 'Linked User',
            'email' => 'linked@user.com',
            'role' => 'Member',
            'password' => 'password',
            'password_confirmation' => 'password',
            'member_id' => $linkedMember->id,
        ]);

        $response->assertRedirect('/users');
        $this->assertDatabaseHas('users', ['email' => 'linked@user.com', 'member_id' => $linkedMember->id]);

        $user = User::where('email', 'linked@user.com')->first();
        $this->assertEquals($linkedMember->member_id, $user->member_id_display);
    }

    public function test_user_can_be_created_with_profile_photo(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)->post('/users', [
            'name' => 'Photo User',
            'email' => 'photo@user.com',
            'role' => 'Finance Clerk',
            'password' => 'password',
            'password_confirmation' => 'password',
            'profile_photo' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $response->assertRedirect('/users');
        $user = User::where('email', 'photo@user.com')->first();
        $this->assertNotNull($user->profile_photo_path);
        $this->assertTrue($user->has_photo);
        Storage::disk('public')->assertExists($user->profile_photo_path);
    }

    public function test_user_index_shows_member_id(): void
    {
        $linkedMember = Member::factory()->create();
        User::factory()->create(['member_id' => $linkedMember->id]);

        $response = $this->actingAs($this->admin)->get('/users');

        $response->assertStatus(200);
        $response->assertSee($linkedMember->member_id);
    }
}
