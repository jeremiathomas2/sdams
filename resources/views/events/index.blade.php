@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Events <span>/ All Events</span></div>
<div class="page-header">
    <div>
        <h2>📅 Church Events</h2>
        <p>Manage church services, meetings, and special events</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap">
        <a href="{{ route('events.create') }}" class="btn btn-primary-solid">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Create Event
        </a>
    </div>
</div>

<div class="grid-auto">
    @foreach($events as $event)
    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px">
            <span class="badge badge-info">{{ $event->type }}</span>
            <div style="display:flex;gap:5px">
                <a href="{{ route('events.edit', $event) }}" class="btn btn-ghost btn-sm"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-ghost btn-sm" style="color:var(--danger)"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
                </form>
            </div>
        </div>
        <h3 class="card-title">{{ $event->title }}</h3>
        <p class="card-sub" style="margin-bottom:12px">{{ $event->description }}</p>
        <div style="font-size:0.85rem;color:var(--text-muted);display:flex;flex-direction:column;gap:5px">
            <div style="display:flex;align-items:center;gap:8px">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                {{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y - h:i A') }}
            </div>
            <div style="display:flex;align-items:center;gap:8px">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                {{ $event->location }}
            </div>
        </div>
        <div style="margin-top:16px">
            <a href="{{ route('events.show', $event) }}" class="btn btn-outline btn-sm" style="width:100%;justify-content:center">View Attendance</a>
        </div>
    </div>
    @endforeach
</div>

<div style="margin-top:20px">
    {{ $events->links() }}
</div>
@endsection
