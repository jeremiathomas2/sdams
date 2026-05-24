@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Reports <span>/ Transfers</span></div>
<div class="page-header">
    <div>
        <h2>📊 Transfer Reports</h2>
        <p>Summary of membership movement</p>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(26,86,160,0.1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#1a56a0" stroke-width="2"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ $totalTransfers }}</div>
            <div class="stat-label">Total Requests</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(217,119,6,0.1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ $pendingTransfers }}</div>
            <div class="stat-label">Pending Approval</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(22,163,74,0.1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ $approvedTransfers }}</div>
            <div class="stat-label">Approved Transfers</div>
        </div>
    </div>
</div>

<div class="card" style="margin-top:20px">
    <div style="text-align:center;padding:40px;color:var(--text-muted)">
        <p>Transfer trends and detailed analytics coming soon...</p>
    </div>
</div>
@endsection
