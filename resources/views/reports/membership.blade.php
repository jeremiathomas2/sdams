@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Reports <span>/ Membership</span></div>
<div class="page-header">
    <div>
        <h2>📊 Membership Reports</h2>
        <p>Statistical overview of church membership</p>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(26,86,160,0.1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#1a56a0" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ $totalMembers }}</div>
            <div class="stat-label">Total Members</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(22,163,74,0.1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ $activeMembers }}</div>
            <div class="stat-label">Active Members</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(217,119,6,0.1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ $inactiveMembers }}</div>
            <div class="stat-label">Inactive Members</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(8,145,178,0.1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#0891b2" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ $baptizedMembers }}</div>
            <div class="stat-label">Baptized Members</div>
        </div>
    </div>
</div>
@endsection
