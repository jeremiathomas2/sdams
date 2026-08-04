<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MemberTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'Administrator']);
    }

    public function test_members_index_is_displayed(): void
    {
        $response = $this->actingAs($this->admin)->get('/members');
        $response->assertStatus(200);
    }

    public function test_member_create_form_is_displayed(): void
    {
        $response = $this->actingAs($this->admin)->get('/members/create');
        $response->assertStatus(200);
    }

    public function test_member_can_be_created(): void
    {
        $response = $this->actingAs($this->admin)->post('/members', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1990-01-01',
            'gender' => 'Male',
            'phone_number' => '0712345678',
            'membership_class' => 'Baptized',
            'membership_status' => 'Active',
        ]);

        $response->assertRedirect('/members');
        $this->assertDatabaseHas('members', ['first_name' => 'John', 'last_name' => 'Doe']);
    }

    public function test_member_show_is_displayed(): void
    {
        $member = Member::factory()->create();

        $response = $this->actingAs($this->admin)->get("/members/{$member->id}");
        $response->assertStatus(200);
    }

    public function test_member_edit_form_is_displayed(): void
    {
        $member = Member::factory()->create();

        $response = $this->actingAs($this->admin)->get("/members/{$member->id}/edit");
        $response->assertStatus(200);
    }

    public function test_member_can_be_updated(): void
    {
        $member = Member::factory()->create();

        $response = $this->actingAs($this->admin)->put("/members/{$member->id}", [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'date_of_birth' => '1990-01-01',
            'gender' => 'Female',
            'phone_number' => '0712345678',
            'membership_class' => 'Baptized',
            'membership_status' => 'Active',
        ]);

        $response->assertRedirect('/members');
        $this->assertDatabaseHas('members', ['id' => $member->id, 'first_name' => 'Jane']);
    }

    public function test_member_can_be_deleted(): void
    {
        $member = Member::factory()->create();

        $response = $this->actingAs($this->admin)->delete("/members/{$member->id}");

        $response->assertRedirect('/members');
        $this->assertDatabaseMissing('members', ['id' => $member->id]);
    }

    public function test_member_search_works(): void
    {
        Member::factory()->create(['first_name' => 'John', 'membership_status' => 'Active']);
        Member::factory()->create(['first_name' => 'Jane', 'membership_status' => 'Inactive']);

        $response = $this->actingAs($this->admin)->get('/members-search?query=John');
        $response->assertStatus(200);
    }

    public function test_member_can_be_created_with_photo(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)->post('/members', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1990-01-01',
            'gender' => 'Male',
            'phone_number' => '0712345678',
            'membership_class' => 'Baptized',
            'membership_status' => 'Active',
            'photo' => UploadedFile::fake()->image('member.jpg'),
        ]);

        $response->assertRedirect('/members');
        $member = Member::where('first_name', 'John')->first();
        $this->assertNotNull($member->photo_path);
        $this->assertTrue($member->has_photo);
        Storage::disk('public')->assertExists($member->photo_path);
    }

    public function test_member_photo_can_be_removed(): void
    {
        Storage::fake('public');
        $member = Member::factory()->create(['photo_path' => 'avatars/members/old.jpg']);
        Storage::disk('public')->put('avatars/members/old.jpg', 'fake-content');

        $response = $this->actingAs($this->admin)->put("/members/{$member->id}", [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'date_of_birth' => '1990-01-01',
            'gender' => 'Female',
            'phone_number' => '0712345678',
            'membership_class' => 'Baptized',
            'membership_status' => 'Active',
            'remove_photo' => '1',
        ]);

        $response->assertRedirect('/members');
        $this->assertDatabaseHas('members', ['id' => $member->id, 'photo_path' => null]);
        Storage::disk('public')->assertMissing('avatars/members/old.jpg');
    }
}
