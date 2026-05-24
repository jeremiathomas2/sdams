@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Membership / <span>New Transfer</span></div>
<div class="page-header">
    <div>
        <h2>🔄 New Transfer Request</h2>
        <p>Initiate a new membership transfer</p>
    </div>
</div>

<div class="card">
    <form action="{{ route('transfers.store') }}" method="POST">
        @csrf
        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">Member</label>
                <select name="member_id" class="form-control" required>
                    <option value="">Select Member</option>
                    @foreach($members as $member)
                    <option value="{{ $member->id }}">{{ $member->full_name }} ({{ $member->member_id }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Transfer Type</label>
                <select name="type" class="form-control" required>
                    <option value="Out">Transfer Out (Leaving this church)</option>
                    <option value="In">Transfer In (Joining this church)</option>
                </select>
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">From Church</label>
                <input type="text" name="from_church" class="form-control" placeholder="e.g. Central SDA Church" required>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">To Church</label>
                <input type="text" name="to_church" class="form-control" placeholder="e.g. Riverside SDA Church" required>
            </div>
        </div>

        <div class="form-group-app">
            <label class="form-label-app">Request Date</label>
            <input type="date" name="request_date" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="form-group-app">
            <label class="form-label-app">Notes/Reason</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px">
            <a href="{{ route('transfers.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary-solid">Submit Request</button>
        </div>
    </form>
</div>
@endsection
