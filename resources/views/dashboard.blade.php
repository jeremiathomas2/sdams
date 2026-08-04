@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home <span>/ Dashboard</span></div>
<div class="page-header">
    <div><h2>📊 Dashboard</h2><p>Welcome back, {{ auth()->user()->name }}. Here's {{ $churchName }} overview.</p></div>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <a href="{{ route('reports.membership') }}" class="btn btn-outline">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            View Reports
        </a>
        <a href="{{ route('members.create') }}" class="btn btn-primary-solid">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Member
        </a>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(26,86,160,0.1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#1a56a0" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ number_format($totalMembers) }}</div>
            <div class="stat-label">Total Members</div>
            <div class="stat-change up">↑ {{ $newMembersThisMonth }} this month</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(22,163,74,0.1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div>
            <div class="stat-val">TZS {{ $monthlyOfferings >= 1000000 ? number_format($monthlyOfferings / 1000000, 1) . 'M' : number_format($monthlyOfferings) }}</div>
            <div class="stat-label">Monthly Offerings</div>
            @if($offeringChange > 0)
            <div class="stat-change up">↑ {{ $offeringChange }}% vs last month</div>
            @elseif($offeringChange < 0)
            <div class="stat-change down">↓ {{ abs($offeringChange) }}% vs last month</div>
            @else
            <div class="stat-change">No change vs last month</div>
            @endif
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(217,119,6,0.1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ $pendingTransfers }}</div>
            <div class="stat-label">Pending Transfers</div>
            @if($pendingTransfers > 0)
            <div class="stat-change down">{{ $pendingTransfers }} awaiting approval</div>
            @else
            <div class="stat-change up">All caught up</div>
            @endif
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(8,145,178,0.1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#0891b2" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ $avgAttendance }}%</div>
            <div class="stat-label">Avg Attendance</div>
        </div>
    </div>
</div>

<div class="grid-2" style="margin-bottom:20px">
    <div class="card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
            <div class="card-title">Monthly Offerings ({{ now()->year }})</div>
            <span class="badge badge-success">Live</span>
        </div>
        <div class="chart-placeholder">
            @php
                $maxOffering = !empty($monthlyOfferingsChart) ? max($monthlyOfferingsChart) : 1;
                $monthLabels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            @endphp
            @for($i = 1; $i <= 12; $i++)
                @php
                    $amount = $monthlyOfferingsChart[$i] ?? 0;
                    $height = $maxOffering > 0 ? round(($amount / $maxOffering) * 100) : 0;
                    $isCurrentMonth = $i == now()->month;
                @endphp
                <div class="chart-bar" style="--i: {{ $i - 1 }};height:{{ max($height, 2) }}%;{{ $isCurrentMonth ? 'background:var(--accent)' : '' }}" title="{{ $monthLabels[$i-1] }}: TZS {{ number_format($amount) }}"></div>
            @endfor
        </div>
        <div style="display:flex;justify-content:space-between;margin-top:8px;font-size:0.75rem;color:var(--text-muted)">
            <span>Jan</span><span>Mar</span><span>May</span><span>Jul</span><span>Sep</span><span>Nov</span>
        </div>
    </div>
    <div class="card">
        <div class="card-title" style="margin-bottom:16px">Membership by Status</div>
        @php
            $statusColors = [
                'Active' => '#1a56a0',
                'Probation' => '#16a34a',
                'Inactive' => '#d97706',
                'Transferred' => '#dc2626',
            ];
            $palette = ['#7c3aed', '#0891b2', '#db2777', '#65a30d', '#f59e0b', '#64748b'];
            $segments = [];
            $running = 0;
            foreach ($statusCounts as $status => $count) {
                $color = $statusColors[$status] ?? $palette[count($segments) % count($palette)];
                $segments[] = ['status' => $status, 'count' => $count, 'color' => $color, 'start' => $running];
                $running += $count;
            }
            $total = max($running, 1);
            $circumference = 2 * 3.14159265358979 * 45;
        @endphp
        <div class="donut-wrap">
            <svg width="120" height="120" viewBox="0 0 120 120">
                <circle cx="60" cy="60" r="45" fill="none" stroke="var(--border)" stroke-width="18"/>
                @foreach($segments as $seg)
                @if($seg['count'] > 0)
                @php($len = ($seg['count'] / $total) * $circumference)
                <circle class="donut-segment" cx="60" cy="60" r="45" fill="none" stroke="{{ $seg['color'] }}" stroke-width="18"
                    style="--i: {{ $loop->index }}; --len: {{ $len }}; --gap: {{ $circumference - $len }}; --circ: {{ $circumference }}; --offset: -{{ ($seg['start'] / $total) * $circumference }}; stroke-dasharray: var(--len) var(--gap); stroke-dashoffset: var(--offset);"
                    transform="rotate(-90 60 60)"/>
                @endif
                @endforeach
                <text x="60" y="64" text-anchor="middle" font-size="14" font-weight="700" fill="var(--text)" font-family="Nunito Sans">{{ number_format($running) }}</text>
            </svg>
            <div class="donut-legend">
                @foreach($segments as $seg)
                @if($seg['count'] > 0)
                <div class="legend-item"><div class="legend-dot" style="background:{{ $seg['color'] }}"></div><span style="font-size:0.82rem"><b>{{ $seg['status'] ?: 'Unspecified' }}</b> — {{ number_format($seg['count']) }}</span></div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="grid-2">
    <div class="card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
            <div class="card-title">Recent Members</div>
            <a href="{{ route('members.index') }}" class="btn btn-ghost btn-sm">View All →</a>
        </div>
        @if($recentMembers->count())
        <div class="table-wrap">
            <table>
                <thead><tr><th>Name</th><th>Status</th><th>Joined</th></tr></thead>
                <tbody>
                    @foreach($recentMembers as $member)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px">
                                @include('partials.avatar', ['entity' => $member, 'size' => 34])
                                {{ $member->full_name }}
                            </div>
                        </td>
                        <td><span class="badge {{ $member->membership_status == 'Active' ? 'badge-success' : ($member->membership_status == 'Inactive' ? 'badge-warning' : 'badge-info') }}">{{ $member->membership_status }}</span></td>
                        <td>{{ $member->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div style="text-align:center;padding:30px;color:var(--text-muted)">
            <p>No members registered yet.</p>
        </div>
        @endif
    </div>
    <div class="card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px">
            <div class="card-title">Recent Contributions</div>
            <a href="{{ route('offerings.index') }}" class="btn btn-ghost btn-sm">View All →</a>
        </div>
        @if($recentOfferings->count())
        <div class="table-wrap">
            <table>
                <thead><tr><th>Member</th><th>Type</th><th>Amount</th><th>Date</th></tr></thead>
                <tbody>
                    @foreach($recentOfferings as $offering)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px">
                                @include('partials.avatar', ['entity' => $offering->member, 'size' => 34])
                                {{ $offering->member->full_name }}
                            </div>
                        </td>
                        <td><span class="badge badge-info">{{ $offering->type }}</span></td>
                        <td><strong>TZS {{ number_format($offering->amount) }}</strong></td>
                        <td>{{ $offering->date }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div style="text-align:center;padding:30px;color:var(--text-muted)">
            <p>No contributions recorded yet.</p>
        </div>
        @endif
    </div>
</div>
@endsection
