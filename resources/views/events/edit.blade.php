@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Events <span>/ Edit Event</span></div>
<div class="page-header">
    <div>
        <h2>✏️ Edit Event</h2>
        <p>Update event details</p>
    </div>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <div>
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
</div>
@endif

<div class="card">
    <form action="{{ route('events.update', $event) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group-app">
            <label class="form-label-app">Event Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $event->title) }}" placeholder="e.g. Sabbath Worship Service" required>
        </div>

        <div class="form-group-app">
            <label class="form-label-app">Description</label>
            <textarea name="description" class="form-control" placeholder="Briefly describe the event...">{{ old('description', $event->description) }}</textarea>
        </div>

        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">Start Time</label>
                <input type="datetime-local" name="start_time" class="form-control" value="{{ old('start_time', \Carbon\Carbon::parse($event->start_time)->format('Y-m-d\TH:i')) }}" required>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">End Time (Optional)</label>
                <input type="datetime-local" name="end_time" class="form-control" value="{{ old('end_time', $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('Y-m-d\TH:i') : '') }}">
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">Location</label>
                <input type="text" name="location" class="form-control" value="{{ old('location', $event->location) }}" placeholder="e.g. Main Sanctuary" required>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Event Type</label>
                <select name="type" class="form-control">
                    @php($typeValue = old('type', $event->type))
                    <option value="Sabbath Service" {{ $typeValue == 'Sabbath Service' ? 'selected' : '' }}>Sabbath Service</option>
                    <option value="Mid-week Prayer" {{ $typeValue == 'Mid-week Prayer' ? 'selected' : '' }}>Mid-week Prayer</option>
                    <option value="Camp Meeting" {{ $typeValue == 'Camp Meeting' ? 'selected' : '' }}>Camp Meeting</option>
                    <option value="Youth Meeting" {{ $typeValue == 'Youth Meeting' ? 'selected' : '' }}>Youth Meeting</option>
                    <option value="Other" {{ $typeValue == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px">
            <a href="{{ route('events.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary-solid">Update Event</button>
        </div>
    </form>
</div>
@endsection
