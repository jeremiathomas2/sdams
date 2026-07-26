@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Finance <span>/ Fund Allocation</span></div>
<div class="page-header">
    <div>
        <h2>🏦 Fund Allocation</h2>
        <p>Manage church funds and their balances</p>
    </div>
</div>

<div class="card" style="margin-bottom:20px">
    <div class="card-title" style="margin-bottom:16px">Create New Fund</div>
    <form action="{{ route('offerings.storeFund') }}" method="POST">
        @csrf
        <div class="grid-3">
            <div class="form-group-app">
                <label class="form-label-app">Fund Name</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Building Fund" required>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Description</label>
                <input type="text" name="description" class="form-control" placeholder="Brief description">
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Initial Balance (TZS)</label>
                <input type="number" name="balance" class="form-control" step="0.01" value="0" min="0">
            </div>
        </div>
        <div style="display:flex;justify-content:flex-end;margin-top:12px">
            <button type="submit" class="btn btn-primary-solid">Create Fund</button>
        </div>
    </form>
</div>

<div class="grid-auto">
    @forelse($funds as $fund)
    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
            <h3 class="card-title">{{ $fund->name }}</h3>
            <span class="badge badge-success">Active</span>
        </div>
        <p class="card-sub" style="margin-bottom:15px">{{ $fund->description ?? 'No description' }}</p>
        <div class="stat-val" style="font-size:1.4rem;color:var(--primary)">TZS {{ number_format($fund->balance, 2) }}</div>
        <div class="stat-label">Current Balance</div>
        <div style="margin-top:20px;display:flex;gap:10px">
            <a href="{{ route('offerings.editFund', $fund) }}" class="btn btn-outline btn-sm" style="flex:1;justify-content:center">Edit</a>
            <form action="{{ route('offerings.destroyFund', $fund) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this fund?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-ghost btn-sm" style="color:var(--danger)">Delete</button>
            </form>
        </div>
    </div>
    @empty
    <div class="card" style="grid-column:1/-1;text-align:center;padding:40px;color:var(--text-muted)">
        <p>No funds created yet. Create your first fund above.</p>
    </div>
    @endforelse
</div>
@endsection
