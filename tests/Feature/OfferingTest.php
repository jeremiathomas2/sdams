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

    public function test_offerings_can_be_searched_by_member_name(): void
    {
        $match = Member::factory()->create(['first_name' => 'Joseph', 'middle_name' => 'M.', 'last_name' => 'Kariwa']);
        $other = Member::factory()->create(['first_name' => 'Anna', 'middle_name' => 'R.', 'last_name' => 'Mwambani']);
        Offering::factory()->create(['member_id' => $match->id, 'amount' => 10000]);
        Offering::factory()->create(['member_id' => $other->id, 'amount' => 20000]);

        $response = $this->actingAs($this->financeClerk)->get('/offerings?q=Kariwa');

        $response->assertStatus(200);
        $response->assertSee('Joseph M. Kariwa')->assertDontSee('Anna R. Mwambani');
    }

    public function test_offerings_can_be_searched_by_member_id(): void
    {
        $match = Member::factory()->create(['member_id' => 'SDA-7777']);
        Offering::factory()->create(['member_id' => $match->id, 'amount' => 10000]);

        $response = $this->actingAs($this->financeClerk)->get('/offerings?q=SDA-7777');

        $response->assertStatus(200)->assertSee('10,000.00');
    }

    public function test_offerings_can_be_filtered_by_type(): void
    {
        Offering::factory()->create(['type' => 'Tithe', 'amount' => 1000]);
        Offering::factory()->create(['type' => 'Camp Meeting', 'amount' => 2000]);

        $response = $this->actingAs($this->financeClerk)->get('/offerings?type=Tithe');

        $response->assertStatus(200);
        $response->assertSee('1,000.00')->assertDontSee('2,000.00');
    }

    public function test_offerings_can_be_filtered_by_fund(): void
    {
        $fundA = Fund::factory()->create(['name' => 'Building Fund']);
        $fundB = Fund::factory()->create(['name' => 'Sabbath School']);
        Offering::factory()->create(['fund_id' => $fundA->id, 'amount' => 5000]);
        Offering::factory()->create(['fund_id' => $fundB->id, 'amount' => 9000]);

        $response = $this->actingAs($this->financeClerk)->get('/offerings?fund=' . $fundA->id);

        $response->assertStatus(200);
        $response->assertSee('5,000.00')->assertDontSee('9,000.00');
    }

    public function test_offerings_can_be_filtered_by_date_range(): void
    {
        Offering::factory()->create(['date' => '2026-07-20', 'amount' => 1000]);
        Offering::factory()->create(['date' => '2026-08-15', 'amount' => 2000]);

        $response = $this->actingAs($this->financeClerk)->get('/offerings?date_from=2026-07-10&date_to=2026-07-31');

        $response->assertStatus(200);
        $response->assertSee('1,000.00')->assertDontSee('2,000.00');
    }

    public function test_offerings_can_be_filtered_by_amount_range(): void
    {
        Offering::factory()->create(['amount' => 500]);
        Offering::factory()->create(['amount' => 5000]);
        Offering::factory()->create(['amount' => 15000]);

        $response = $this->actingAs($this->financeClerk)->get('/offerings?amount_min=1000&amount_max=10000');

        $response->assertStatus(200);
        $response->assertSee('5,000.00')->assertDontSee('500.00')->assertDontSee('15,000.00');
    }

    public function test_offerings_can_be_filtered_by_receipt_presence(): void
    {
        Offering::factory()->create(['receipt_number' => 'REC-100', 'amount' => 1000]);
        Offering::factory()->create(['receipt_number' => null, 'amount' => 2000]);

        $response = $this->actingAs($this->financeClerk)->get('/offerings?has_receipt=1');

        $response->assertStatus(200);
        $response->assertSee('1,000.00')->assertDontSee('2,000.00');
    }

    public function test_offerings_summary_shows_filtered_count_and_total(): void
    {
        Offering::factory()->create(['type' => 'Tithe', 'amount' => 1000]);
        Offering::factory()->create(['type' => 'Tithe', 'amount' => 3000]);
        Offering::factory()->create(['type' => 'Other', 'amount' => 9999]);

        $response = $this->actingAs($this->financeClerk)->get('/offerings?type=Tithe');

        $response->assertStatus(200);
        $response->assertSee('>2</strong> records found', false);
        $response->assertSee('TZS 4,000.00');
        $response->assertDontSee('9,999.00');
    }
}
