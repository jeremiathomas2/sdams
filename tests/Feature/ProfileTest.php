<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed_for_any_role(): void
    {
        foreach (['Administrator', 'Pastor', 'Finance Clerk', 'Membership Clerk', 'Member'] as $role) {
            $user = User::factory()->create(['role' => $role]);

            $response = $this->actingAs($user)->get('/profile');
            $response->assertStatus(200);
            $response->assertSee($user->name);
        }
    }

    public function test_profile_page_requires_authentication(): void
    {
        $response = $this->get('/profile');
        $response->assertRedirect('/');
    }

    public function test_profile_can_be_updated(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/profile', [
            'name' => 'Updated Name',
            'profile_photo' => UploadedFile::fake()->image('profile.jpg'),
        ]);

        $response->assertRedirect('/profile');
        $user->refresh();
        $this->assertEquals('Updated Name', $user->name);
        $this->assertNotNull($user->profile_photo_path);
        Storage::disk('public')->assertExists($user->profile_photo_path);
    }

    public function test_profile_photo_can_be_removed(): void
    {
        Storage::fake('public');
        $user = User::factory()->create(['profile_photo_path' => 'avatars/users/old.jpg']);
        Storage::disk('public')->put('avatars/users/old.jpg', 'fake-content');

        $response = $this->actingAs($user)->put('/profile', [
            'name' => $user->name,
            'remove_photo' => '1',
        ]);

        $response->assertRedirect('/profile');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'profile_photo_path' => null]);
        Storage::disk('public')->assertMissing('avatars/users/old.jpg');
    }

    public function test_profile_rejects_invalid_photo(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/profile', [
            'name' => $user->name,
            'profile_photo' => UploadedFile::fake()->create('document.txt'),
        ]);

        $response->assertSessionHasErrors('profile_photo');
    }
}
