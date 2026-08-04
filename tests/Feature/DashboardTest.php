<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_every_membership_status_in_pie_chart(): void
    {
        Member::factory()->create(['membership_status' => 'Active']);
        Member::factory()->create(['membership_status' => 'Active']);
        Member::factory()->create(['membership_status' => 'Inactive']);
        Member::factory()->create(['membership_status' => 'Probation']);
        Member::factory()->create(['membership_status' => 'Transferred']);
        Member::factory()->create(['membership_status' => 'Disfellowshipped']);

        $response = $this->actingAs(User::factory()->create())->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Disfellowshipped');
        $response->assertSee('>6</text>', false);
    }

    public function test_dashboard_pie_chart_segment_sizes_sum_to_circumference(): void
    {
        Member::factory()->create(['membership_status' => 'Active']);
        Member::factory()->create(['membership_status' => 'Inactive']);

        $response = $this->actingAs(User::factory()->create())->get('/dashboard');

        $circumference = 2 * 3.14159265358979 * 45;
        $half = (1 / 2) * $circumference;

        $response->assertStatus(200);
        $response->assertSee("--len: {$half}; --gap: {$half}", false);
        $response->assertSee("--offset: -{$half}", false);
        $response->assertSee('class="donut-segment"', false);
    }
}
