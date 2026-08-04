@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Members <span>/ {{ $member->full_name }}</span></div>
<div class="page-header">
    <div>
        <h2>👤 Member Profile</h2>
        <p>Viewing details for {{ $member->member_id }}</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap">
        <a href="{{ route('members.index') }}" class="btn btn-outline">Back to List</a>
        <a href="{{ route('members.edit', $member) }}" class="btn btn-primary-solid">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Edit Member
        </a>
    </div>
</div>

<div style="display:flex;align-items:center;gap:16px;margin-bottom:20px">
    @include('partials.avatar', ['entity' => $member, 'size' => 64, 'fontSize' => '1.4rem', 'extraStyle' => 'border:2px solid var(--border)'])
    <div>
        <div style="font-weight:800;font-size:1.2rem">{{ $member->full_name }}</div>
        <div style="color:var(--text-muted);font-size:0.9rem">{{ $member->member_id }} &middot; {{ $member->gender }}</div>
    </div>
    <span class="badge {{ $member->membership_status == 'Active' ? 'badge-success' : ($member->membership_status == 'Inactive' ? 'badge-warning' : 'badge-info') }}" style="margin-left:auto">
        {{ $member->membership_status }}
    </span>
</div>

<div class="stats-grid" style="margin-bottom:20px">
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(22,163,74,0.1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ $member->offerings->count() }}</div>
            <div class="stat-label">Total Contributions</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(26,86,160,0.1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#1a56a0" stroke-width="2"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ $member->transfers->count() }}</div>
            <div class="stat-label">Transfers</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(8,145,178,0.1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#0891b2" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ $member->attendances->count() }}</div>
            <div class="stat-label">Attendances</div>
        </div>
    </div>
</div>

<div class="grid-2">
    <div class="card">
        <div class="card-title" style="margin-bottom:16px">Personal Information</div>
        <div class="grid-2">
            <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
                <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Date of Birth</div>
                <div style="font-weight:800">{{ \Carbon\Carbon::parse($member->date_of_birth)->format('M d, Y') }}</div>
            </div>
            <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
                <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Gender</div>
                <div style="font-weight:800">{{ $member->gender }}</div>
            </div>
        </div>
        <div class="grid-2" style="margin-top:12px">
            <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
                <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Marital Status</div>
                <div style="font-weight:800">{{ $member->marital_status ?? 'Not specified' }}</div>
            </div>
            <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
                <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Department/Ministry</div>
                <div style="font-weight:800">{{ $member->department_ministry ?? 'Not assigned' }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-title" style="margin-bottom:16px">Contact & Membership</div>
        <div class="grid-2">
            <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
                <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Phone Number</div>
                <div style="font-weight:800">{{ $member->phone_number }}</div>
            </div>
            <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
                <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Email</div>
                <div style="font-weight:800">{{ $member->email ?? 'Not provided' }}</div>
            </div>
        </div>
        <div class="grid-2" style="margin-top:12px">
            <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
                <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Membership Class</div>
                <div style="font-weight:800">{{ $member->membership_class }}</div>
            </div>
            <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
                <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Baptism Date</div>
                <div style="font-weight:800">{{ $member->baptism_date ? \Carbon\Carbon::parse($member->baptism_date)->format('M d, Y') : 'N/A' }}</div>
            </div>
        </div>
        <div style="margin-top:12px;padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Residential Address</div>
            <div style="font-weight:800">{{ $member->residential_address ?? 'Not provided' }}</div>
        </div>
    </div>
</div>

@if($member->offerings->count())
<div class="card" style="margin-top:20px">
    <div class="card-title" style="margin-bottom:16px">Recent Contributions</div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Amount (TZS)</th>
                    <th>Receipt #</th>
                </tr>
            </thead>
            <tbody>
                @foreach($member->offerings->take(5) as $offering)
                <tr>
                    <td>{{ $offering->date }}</td>
                    <td><span class="badge badge-info">{{ $offering->type }}</span></td>
                    <td><strong>{{ number_format($offering->amount, 2) }}</strong></td>
                    <td>{{ $offering->receipt_number ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
