<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use App\Models\Member;
use App\Models\Attendance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => 'Administrator']);
    }

    public function test_events_index_is_displayed(): void
    {
        $response = $this->actingAs($this->user)->get('/events');
        $response->assertStatus(200);
    }

    public function test_event_create_form_is_displayed(): void
    {
        $response = $this->actingAs($this->user)->get('/events/create');
        $response->assertStatus(200);
    }

    public function test_event_can_be_created(): void
    {
        $response = $this->actingAs($this->user)->post('/events', [
            'title' => 'Sabbath Service',
            'description' => 'Weekly worship',
            'start_time' => '2026-07-26 09:00',
            'end_time' => '2026-07-26 12:00',
            'location' => 'Main Sanctuary',
            'type' => 'Sabbath Service',
        ]);

        $response->assertRedirect('/events');
        $this->assertDatabaseHas('events', ['title' => 'Sabbath Service']);
    }

    public function test_event_show_is_displayed(): void
    {
        $event = Event::factory()->create();

        $response = $this->actingAs($this->user)->get("/events/{$event->id}");
        $response->assertStatus(200);
    }

    public function test_event_edit_form_is_displayed(): void
    {
        $event = Event::factory()->create();

        $response = $this->actingAs($this->user)->get("/events/{$event->id}/edit");
        $response->assertStatus(200);
    }

    public function test_event_can_be_deleted(): void
    {
        $event = Event::factory()->create();

        $response = $this->actingAs($this->user)->delete("/events/{$event->id}");

        $response->assertRedirect('/events');
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }

    public function test_attendance_page_is_displayed(): void
    {
        $response = $this->actingAs($this->user)->get('/events-attendance');
        $response->assertStatus(200);
    }

    public function test_attendance_can_be_recorded(): void
    {
        $event = Event::factory()->create();
        $member = Member::factory()->create();

        $response = $this->actingAs($this->user)->post('/events-attendance', [
            'event_id' => $event->id,
            'members' => [$member->id => 'Present'],
        ]);

        $response->assertRedirect('/events-attendance');
        $this->assertDatabaseHas('attendances', [
            'event_id' => $event->id,
            'member_id' => $member->id,
            'status' => 'Present',
        ]);
    }
}
