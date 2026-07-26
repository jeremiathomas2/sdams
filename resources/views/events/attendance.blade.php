@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Events <span>/ Attendance Tracker</span></div>
<div class="page-header">
    <div>
        <h2>📋 Attendance Tracker</h2>
        <p>Record attendance for church events</p>
    </div>
</div>

<div class="card">
    <form action="{{ route('events.attendance.store') }}" method="POST">
        @csrf
        <div class="form-group-app">
            <label class="form-label-app">Select Event</label>
            <select name="event_id" class="form-control" id="event-select" required>
                <option value="">Choose an event...</option>
                @foreach($events as $event)
                <option value="{{ $event->id }}">{{ $event->title }} — {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y') }}</option>
                @endforeach
            </select>
        </div>

        <div id="attendance-section" style="display:none">
            <div class="card-title" style="margin:20px 0 12px">Mark Attendance</div>
            <p style="color:var(--text-muted);font-size:0.85rem;margin-bottom:16px">Select the attendance status for each member:</p>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Member ID</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:8px">
                                    <div class="member-avatar">{{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}</div>
                                    {{ $member->full_name }}
                                </div>
                            </td>
                            <td><code>{{ $member->member_id }}</code></td>
                            <td>
                                <select name="members[{{ $member->id }}]" class="form-control" style="width:auto">
                                    <option value="">— Skip —</option>
                                    <option value="Present">Present</option>
                                    <option value="Absent">Absent</option>
                                    <option value="Late">Late</option>
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px">
                <button type="submit" class="btn btn-primary-solid">Save Attendance</button>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('event-select').addEventListener('change', function() {
    document.getElementById('attendance-section').style.display = this.value ? 'block' : 'none';
});
</script>
@endsection
