@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Finance / <span>Edit Offering</span></div>
<div class="page-header">
    <div>
        <h2>✏️ Edit Offering</h2>
        <p>Update contribution or offering record</p>
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
    <form action="{{ route('offerings.update', $offering) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">Member</label>
                <select name="member_id" class="form-control" required>
                    <option value="">Select Member</option>
                    @foreach($members as $member)
                    <option value="{{ $member->id }}" {{ (string) old('member_id', $offering->member_id) === (string) $member->id ? 'selected' : '' }}>
                        {{ $member->full_name }} ({{ $member->member_id }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Date</label>
                <input type="date" name="date" class="form-control" value="{{ old('date', $offering->date) }}" required>
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">Amount (TZS)</label>
                <input type="number" name="amount" class="form-control" step="0.01" value="{{ old('amount', $offering->amount) }}" required>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Offering Type</label>
                <select name="type" class="form-control" required>
                    @php($typeValue = old('type', $offering->type))
                    <option value="Tithe" {{ $typeValue === 'Tithe' ? 'selected' : '' }}>Tithe</option>
                    <option value="Combined Offering" {{ $typeValue === 'Combined Offering' ? 'selected' : '' }}>Combined Offering</option>
                    <option value="Camp Meeting" {{ $typeValue === 'Camp Meeting' ? 'selected' : '' }}>Camp Meeting</option>
                    <option value="Building Fund" {{ $typeValue === 'Building Fund' ? 'selected' : '' }}>Building Fund</option>
                    <option value="Other" {{ $typeValue === 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">Receipt Number (Optional)</label>
                <input type="text" name="receipt_number" class="form-control" value="{{ old('receipt_number', $offering->receipt_number) }}">
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Fund Allocation</label>
                <select name="fund_id" class="form-control">
                    <option value="">No Specific Fund</option>
                    @foreach($funds as $fund)
                    <option value="{{ $fund->id }}" {{ (string) old('fund_id', $offering->fund_id) === (string) $fund->id ? 'selected' : '' }}>
                        {{ $fund->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group-app">
            <label class="form-label-app">Notes</label>
            <textarea name="notes" class="form-control">{{ old('notes', $offering->notes) }}</textarea>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px">
            <a href="{{ route('offerings.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary-solid">Update Offering</button>
        </div>
    </form>
</div>
@endsection
