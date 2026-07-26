<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'members' => 'required|array',
        ]);

        $eventId = $request->event_id;
        $members = $request->members;

        foreach ($members as $memberId => $status) {
            if (empty($status)) {
                continue;
            }

            Attendance::updateOrCreate(
                ['event_id' => $eventId, 'member_id' => $memberId],
                ['status' => $status]
            );
        }

        return redirect()->route('events.attendance')->with('success', 'Attendance recorded successfully!');
    }
}
