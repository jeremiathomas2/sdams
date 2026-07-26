@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Transfers <span>/ Transfer Details</span></div>
<div class="page-header">
    <div>
        <h2>🔄 Transfer Details</h2>
        <p>Transfer request for {{ $transfer->member->full_name }}</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap">
        <a href="{{ route('transfers.index') }}" class="btn btn-outline">Back to List</a>
        @if($transfer->status == 'Pending')
        <a href="{{ route('transfers.edit', $transfer) }}" class="btn btn-primary-solid">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Review
        </a>
        @endif
    </div>
</div>

<div class="card">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:18px">
        <div class="member-avatar" style="width:44px;height:44px;font-size:1rem">{{ substr($transfer->member->first_name, 0, 1) }}{{ substr($transfer->member->last_name, 0, 1) }}</div>
        <div>
            <div style="font-weight:800;font-size:1.05rem">{{ $transfer->member->full_name }}</div>
            <div style="color:var(--text-muted);font-size:0.85rem">{{ $transfer->member->member_id }}</div>
        </div>
        <span class="badge {{ $transfer->status == 'Approved' ? 'badge-success' : ($transfer->status == 'Pending' ? 'badge-warning' : 'badge-danger') }}" style="margin-left:auto">
            {{ $transfer->status }}
        </span>
    </div>

    <div class="grid-2">
        <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Transfer Type</div>
            <div style="font-weight:800">
                <span class="badge {{ $transfer->type == 'In' ? 'badge-info' : 'badge-warning' }}">
                    Transfer {{ $transfer->type }}
                </span>
            </div>
        </div>
        <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Request Date</div>
            <div style="font-weight:800">{{ \Carbon\Carbon::parse($transfer->request_date)->format('M d, Y') }}</div>
        </div>
    </div>

    <div class="grid-2" style="margin-top:12px">
        <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">From Church</div>
            <div style="font-weight:800">{{ $transfer->from_church }}</div>
        </div>
        <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">To Church</div>
            <div style="font-weight:800">{{ $transfer->to_church }}</div>
        </div>
    </div>

    @if($transfer->approval_date)
    <div style="margin-top:12px;padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
        <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Approval Date</div>
        <div style="font-weight:800">{{ \Carbon\Carbon::parse($transfer->approval_date)->format('M d, Y') }}</div>
    </div>
    @endif

    @if($transfer->notes)
    <div style="margin-top:12px;padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
        <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Notes</div>
        <div style="font-weight:800">{{ $transfer->notes }}</div>
    </div>
    @endif
</div>
@endsection
