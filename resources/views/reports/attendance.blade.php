@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Reports <span>/ Attendance</span></div>
<div class="page-header">
    <div>
        <h2>📊 Attendance Reports</h2>
        <p>Track member participation in church events</p>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Event Date</th>
                    <th>Event Title</th>
                    <th>Event Type</th>
                    <th>Attendance Count</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($event->start_time)->format('M d, Y') }}</td>
                    <td>{{ $event->title }}</td>
                    <td><span class="badge badge-info">{{ $event->type }}</span></td>
                    <td><strong>{{ $event->attendances_count }}</strong></td>
                    <td>
                        <a href="{{ route('events.show', $event) }}" class="btn btn-ghost btn-sm">View Details</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
