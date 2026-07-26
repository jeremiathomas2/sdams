@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Finance <span>/ Edit Fund</span></div>
<div class="page-header">
    <div>
        <h2>✏️ Edit Fund</h2>
        <p>Update fund details</p>
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
    <form action="{{ route('offerings.updateFund', $fund) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group-app">
            <label class="form-label-app">Fund Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $fund->name) }}" required>
        </div>
        <div class="form-group-app">
            <label class="form-label-app">Description</label>
            <textarea name="description" class="form-control">{{ old('description', $fund->description) }}</textarea>
        </div>
        <div class="form-group-app">
            <label class="form-label-app">Current Balance (TZS)</label>
            <input type="number" name="balance" class="form-control" step="0.01" value="{{ old('balance', $fund->balance) }}" required>
        </div>
        <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px">
            <a href="{{ route('offerings.funds') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary-solid">Update Fund</button>
        </div>
    </form>
</div>
@endsection
