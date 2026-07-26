<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Member;
use App\Models\Transfer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransferTest extends TestCase
{
    use RefreshDatabase;

    protected User $membershipClerk;

    protected function setUp(): void
    {
        parent::setUp();
        $this->membershipClerk = User::factory()->create(['role' => 'Membership Clerk']);
    }

    public function test_transfers_index_is_displayed(): void
    {
        $response = $this->actingAs($this->membershipClerk)->get('/transfers');
        $response->assertStatus(200);
    }

    public function test_transfer_create_form_is_displayed(): void
    {
        $response = $this->actingAs($this->membershipClerk)->get('/transfers/create');
        $response->assertStatus(200);
    }

    public function test_transfer_can_be_created(): void
    {
        $member = Member::factory()->create();

        $response = $this->actingAs($this->membershipClerk)->post('/transfers', [
            'member_id' => $member->id,
            'type' => 'Out',
            'from_church' => 'Central SDA',
            'to_church' => 'Riverside SDA',
            'request_date' => '2026-07-26',
        ]);

        $response->assertRedirect('/transfers');
        $this->assertDatabaseHas('transfers', ['member_id' => $member->id, 'type' => 'Out']);
    }

    public function test_transfer_approval_updates_member_status(): void
    {
        $member = Member::factory()->create(['membership_status' => 'Active']);
        $transfer = Transfer::factory()->create([
            'member_id' => $member->id,
            'type' => 'Out',
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($this->membershipClerk)->put("/transfers/{$transfer->id}", [
            'status' => 'Approved',
            'approval_date' => '2026-07-26',
        ]);

        $response->assertRedirect('/transfers');
        $this->assertDatabaseHas('members', ['id' => $member->id, 'membership_status' => 'Transferred']);
    }

    public function test_transfer_can_be_deleted(): void
    {
        $transfer = Transfer::factory()->create();

        $response = $this->actingAs($this->membershipClerk)->delete("/transfers/{$transfer->id}");

        $response->assertRedirect('/transfers');
        $this->assertDatabaseMissing('transfers', ['id' => $transfer->id]);
    }

    public function test_pending_transfers_page_is_displayed(): void
    {
        $response = $this->actingAs($this->membershipClerk)->get('/transfers-pending');
        $response->assertStatus(200);
    }

    public function test_transfer_history_page_is_displayed(): void
    {
        $response = $this->actingAs($this->membershipClerk)->get('/transfers-history');
        $response->assertStatus(200);
    }
}
