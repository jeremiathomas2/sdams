<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Member;
use App\Models\Attendance;
use App\Services\AuditService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->paginate(10);
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'type' => 'nullable|string',
        ]);

        $event = Event::create($validated);

        AuditService::created('Event', $event->id, $validated, 'Event created: ' . $event->title);

        return redirect()->route('events.index')->with('success', 'Event created successfully!');
    }

    public function show(Event $event)
    {
        $attendances = $event->attendances()->with('member')->get();
        return view('events.show', compact('event', 'attendances'));
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'type' => 'nullable|string',
        ]);

        $oldData = $event->toArray();
        $event->update($validated);

        AuditService::updated('Event', $event->id, $oldData, $validated, 'Event updated: ' . $event->title);

        return redirect()->route('events.index')->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        $oldData = $event->toArray();
        $event->delete();

        AuditService::deleted('Event', $event->id, $oldData, 'Event deleted: ' . $oldData['title']);

        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }

    public function attendance()
    {
        $events = Event::latest()->get();
        $members = Member::all();
        return view('events.attendance', compact('events', 'members'));
    }
}
