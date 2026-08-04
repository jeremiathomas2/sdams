@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Events <span>/ {{ $event->title }}</span></div>
<div class="page-header">
    <div>
        <h2>📅 Event Details</h2>
        <p>{{ $event->title }}</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap">
        <a href="{{ route('events.index') }}" class="btn btn-outline">Back to Events</a>
        <a href="{{ route('events.edit', $event) }}" class="btn btn-primary-solid">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Edit Event
        </a>
    </div>
</div>

<div class="grid-2" style="margin-bottom:20px">
    <div class="card">
        <div class="card-title" style="margin-bottom:16px">Event Information</div>
        <div style="display:flex;gap:8px;margin-bottom:12px">
            <span class="badge badge-info">{{ $event->type ?? 'General' }}</span>
        </div>
        <div class="grid-2">
            <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
                <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Start Time</div>
                <div style="font-weight:800">{{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y - h:i A') }}</div>
            </div>
            <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
                <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">End Time</div>
                <div style="font-weight:800">{{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('M d, Y - h:i A') : 'Not set' }}</div>
            </div>
        </div>
        <div style="margin-top:12px;padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Location</div>
            <div style="font-weight:800">{{ $event->location ?? 'Not specified' }}</div>
        </div>
        @if($event->description)
        <div style="margin-top:12px;padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Description</div>
            <div style="font-weight:800">{{ $event->description }}</div>
        </div>
        @endif
    </div>

    <div class="card">
        <div class="card-title" style="margin-bottom:16px">Attendance Summary</div>
        <div class="stats-grid" style="grid-template-columns:1fr 1fr 1fr">
            <div style="text-align:center;padding:16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
                <div style="font-size:1.4rem;font-weight:800;color:var(--success)">{{ $attendances->where('status', 'Present')->count() }}</div>
                <div style="font-size:0.82rem;color:var(--text-muted)">Present</div>
            </div>
            <div style="text-align:center;padding:16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
                <div style="font-size:1.4rem;font-weight:800;color:var(--warning)">{{ $attendances->where('status', 'Late')->count() }}</div>
                <div style="font-size:0.82rem;color:var(--text-muted)">Late</div>
            </div>
            <div style="text-align:center;padding:16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
                <div style="font-size:1.4rem;font-weight:800;color:var(--danger)">{{ $attendances->where('status', 'Absent')->count() }}</div>
                <div style="font-size:0.82rem;color:var(--text-muted)">Absent</div>
            </div>
        </div>
        <div style="margin-top:16px">
            <div style="font-size:0.85rem;color:var(--text-muted);margin-bottom:8px">Total Recorded: <strong>{{ $attendances->count() }}</strong></div>
        </div>
    </div>
</div>

<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
        <div class="card-title">Attendance Records</div>
    </div>
    @if($attendances->count())
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
                @foreach($attendances as $attendance)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px">
                            @include('partials.avatar', ['entity' => $attendance->member, 'size' => 34])
                            {{ $attendance->member->full_name }}
                        </div>
                    </td>
                    <td><code>{{ $attendance->member->member_id }}</code></td>
                    <td>
                        <span class="badge {{ $attendance->status == 'Present' ? 'badge-success' : ($attendance->status == 'Late' ? 'badge-warning' : 'badge-danger') }}">
                            {{ $attendance->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="text-align:center;padding:40px;color:var(--text-muted)">
        <p>No attendance records yet for this event.</p>
    </div>
    @endif
</div>
@endsection
