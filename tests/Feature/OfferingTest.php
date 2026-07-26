<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Member;
use App\Models\Offering;
use App\Models\Fund;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OfferingTest extends TestCase
{
    use RefreshDatabase;

    protected User $financeClerk;

    protected function setUp(): void
    {
        parent::setUp();
        $this->financeClerk = User::factory()->create(['role' => 'Finance Clerk']);
    }

    public function test_offerings_index_is_displayed(): void
    {
        $response = $this->actingAs($this->financeClerk)->get('/offerings');
        $response->assertStatus(200);
    }

    public function test_offering_create_form_is_displayed(): void
    {
        $response = $this->actingAs($this->financeClerk)->get('/offerings/create');
        $response->assertStatus(200);
    }

    public function test_offering_can_be_created(): void
    {
        $member = Member::factory()->create();

        $response = $this->actingAs($this->financeClerk)->post('/offerings', [
            'member_id' => $member->id,
            'amount' => 50000,
            'type' => 'Tithe',
            'date' => '2026-07-26',
        ]);

        $response->assertRedirect('/offerings');
        $this->assertDatabaseHas('offerings', ['member_id' => $member->id, 'amount' => 50000]);
    }

    public function test_offering_with_fund_updates_balance(): void
    {
        $member = Member::factory()->create();
        $fund = Fund::factory()->create(['balance' => 100000]);

        $response = $this->actingAs($this->financeClerk)->post('/offerings', [
            'member_id' => $member->id,
            'amount' => 50000,
            'type' => 'Tithe',
            'date' => '2026-07-26',
            'fund_id' => $fund->id,
        ]);

        $response->assertRedirect('/offerings');
        $this->assertDatabaseHas('funds', ['id' => $fund->id, 'balance' => 150000]);
    }

    public function test_offering_can_be_deleted(): void
    {
        $fund = Fund::factory()->create(['balance' => 100000]);
        $offering = Offering::factory()->create(['fund_id' => $fund->id, 'amount' => 50000]);

        $response = $this->actingAs($this->financeClerk)->delete("/offerings/{$offering->id}");

        $response->assertRedirect('/offerings');
        $this->assertDatabaseMissing('offerings', ['id' => $offering->id]);
        $this->assertDatabaseHas('funds', ['id' => $fund->id, 'balance' => 50000]);
    }

    public function test_fund_can_be_created(): void
    {
        $response = $this->actingAs($this->financeClerk)->post('/finance-funds', [
            'name' => 'Building Fund',
            'description' => 'For church construction',
            'balance' => 0,
        ]);

        $response->assertRedirect('/finance-funds');
        $this->assertDatabaseHas('funds', ['name' => 'Building Fund']);
    }

    public function test_csv_export_works(): void
    {
        $response = $this->actingAs($this->financeClerk)->get('/finance-export');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=utf-8');
    }
}
