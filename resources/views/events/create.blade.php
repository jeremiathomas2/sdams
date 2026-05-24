@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Events / <span>Create Event</span></div>
<div class="page-header">
    <div>
        <h2>📅 Create New Event</h2>
        <p>Schedule a new church event</p>
    </div>
</div>

<div class="card">
    <form action="{{ route('events.store') }}" method="POST">
        @csrf
        <div class="form-group-app">
            <label class="form-label-app">Event Title</label>
            <input type="text" name="title" class="form-control" placeholder="e.g. Sabbath Worship Service" required>
        </div>

        <div class="form-group-app">
            <label class="form-label-app">Description</label>
            <textarea name="description" class="form-control" placeholder="Briefly describe the event..."></textarea>
        </div>

        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">Start Time</label>
                <input type="datetime-local" name="start_time" class="form-control" required>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">End Time (Optional)</label>
                <input type="datetime-local" name="end_time" class="form-control">
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">Location</label>
                <input type="text" name="location" class="form-control" placeholder="e.g. Main Sanctuary" required>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Event Type</label>
                <select name="type" class="form-control">
                    <option value="Sabbath Service">Sabbath Service</option>
                    <option value="Mid-week Prayer">Mid-week Prayer</option>
                    <option value="Camp Meeting">Camp Meeting</option>
                    <option value="Youth Meeting">Youth Meeting</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px">
            <a href="{{ route('events.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary-solid">Create Event</button>
        </div>
    </form>
</div>
@endsection
