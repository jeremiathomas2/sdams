@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Finance / <span>Record Offering</span></div>
<div class="page-header">
    <div>
        <h2>💰 Record Offering</h2>
        <p>Record a new contribution or offering</p>
    </div>
</div>

<div class="card">
    <form action="{{ route('offerings.store') }}" method="POST">
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
                <label class="form-label-app">Date</label>
                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">Amount (TZS)</label>
                <input type="number" name="amount" class="form-control" step="0.01" required>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Offering Type</label>
                <select name="type" class="form-control" required>
                    <option value="Tithe">Tithe</option>
                    <option value="Combined Offering">Combined Offering</option>
                    <option value="Camp Meeting">Camp Meeting</option>
                    <option value="Building Fund">Building Fund</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">Receipt Number (Optional)</label>
                <input type="text" name="receipt_number" class="form-control">
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Fund Allocation</label>
                <select name="fund_id" class="form-control">
                    <option value="">No Specific Fund</option>
                    @foreach($funds as $fund)
                    <option value="{{ $fund->id }}">{{ $fund->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group-app">
            <label class="form-label-app">Notes</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px">
            <a href="{{ route('offerings.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary-solid">Save Record</button>
        </div>
    </form>
</div>
@endsection
