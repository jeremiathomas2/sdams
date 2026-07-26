<?php

namespace Tests\Unit;

use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_name_accessor(): void
    {
        $member = Member::factory()->create([
            'first_name' => 'John',
            'middle_name' => 'David',
            'last_name' => 'Mwangi',
        ]);

        $this->assertEquals('John David Mwangi', $member->full_name);
    }

    public function test_full_name_without_middle_name(): void
    {
        $member = Member::factory()->create([
            'first_name' => 'John',
            'middle_name' => null,
            'last_name' => 'Mwangi',
        ]);

        $this->assertEquals('John  Mwangi', $member->full_name);
    }

    public function test_member_has_offerings_relationship(): void
    {
        $member = Member::factory()->create();
        $member->offerings()->create([
            'amount' => 50000,
            'type' => 'Tithe',
            'date' => '2026-07-26',
        ]);

        $this->assertCount(1, $member->offerings);
    }

    public function test_member_has_transfers_relationship(): void
    {
        $member = Member::factory()->create();
        $member->transfers()->create([
            'type' => 'Out',
            'from_church' => 'Central SDA',
            'to_church' => 'Riverside SDA',
            'request_date' => '2026-07-26',
        ]);

        $this->assertCount(1, $member->transfers);
    }

    public function test_member_has_attendances_relationship(): void
    {
        $member = Member::factory()->create();
        $event = \App\Models\Event::factory()->create();
        $member->attendances()->create([
            'event_id' => $event->id,
            'status' => 'Present',
        ]);

        $this->assertCount(1, $member->attendances);
    }
}
