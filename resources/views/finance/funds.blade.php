@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Finance <span>/ Fund Allocation</span></div>
<div class="page-header">
    <div>
        <h2>🏦 Fund Allocation</h2>
        <p>Manage church funds and their balances</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap">
        <button class="btn btn-primary-solid" onclick="showToast('Fund','New fund creation coming soon...','info')">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Create New Fund
        </button>
    </div>
</div>

<div class="grid-auto">
    @foreach($funds as $fund)
    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
            <h3 class="card-title">{{ $fund->name }}</h3>
            <span class="badge badge-success">Active</span>
        </div>
        <p class="card-sub" style="margin-bottom:15px">{{ $fund->description }}</p>
        <div class="stat-val" style="font-size:1.4rem;color:var(--primary)">TZS {{ number_format($fund->balance, 2) }}</div>
        <div class="stat-label">Current Balance</div>
        <div style="margin-top:20px;display:flex;gap:10px">
            <button class="btn btn-outline btn-sm" style="flex:1">View History</button>
            <button class="btn btn-ghost btn-sm">Edit</button>
        </div>
    </div>
    @endforeach
</div>
@endsection
