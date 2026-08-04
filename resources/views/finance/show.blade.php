@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Finance <span>/ Contribution Details</span></div>
<div class="page-header">
    <div>
        <h2>💰 Contribution Details</h2>
        <p>Recorded for {{ $offering->member->full_name }}</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap">
        <a href="{{ route('offerings.index') }}" class="btn btn-outline">Back to List</a>
        <a href="{{ route('offerings.edit', $offering) }}" class="btn btn-primary-solid">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Edit
        </a>
    </div>
</div>

<div class="card">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:18px">
        @include('partials.avatar', ['entity' => $offering->member, 'size' => 44, 'fontSize' => '1rem'])
        <div>
            <div style="font-weight:800;font-size:1.05rem">{{ $offering->member->full_name }}</div>
            <div style="color:var(--text-muted);font-size:0.85rem">{{ $offering->member->member_id }}</div>
        </div>
    </div>

    <div class="grid-2">
        <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Amount</div>
            <div style="font-weight:800;font-size:1.2rem">TZS {{ number_format($offering->amount, 2) }}</div>
        </div>
        <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Type</div>
            <div style="font-weight:800"><span class="badge badge-info">{{ $offering->type }}</span></div>
        </div>
    </div>

    <div class="grid-2" style="margin-top:12px">
        <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Date</div>
            <div style="font-weight:800">{{ \Carbon\Carbon::parse($offering->date)->format('M d, Y') }}</div>
        </div>
        <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Receipt Number</div>
            <div style="font-weight:800">{{ $offering->receipt_number ?? 'N/A' }}</div>
        </div>
    </div>

    <div class="grid-2" style="margin-top:12px">
        <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Fund Allocation</div>
            <div style="font-weight:800">{{ $offering->fund->name ?? 'No specific fund' }}</div>
        </div>
        <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Recorded</div>
            <div style="font-weight:800">{{ $offering->created_at->format('M d, Y H:i') }}</div>
        </div>
    </div>

    @if($offering->notes)
    <div style="margin-top:12px;padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
        <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Notes</div>
        <div style="font-weight:800">{{ $offering->notes }}</div>
    </div>
    @endif

    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px">
        <form action="{{ route('offerings.destroy', $offering) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this contribution record?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-ghost" style="color:var(--danger)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                Delete Record
            </button>
        </form>
    </div>
</div>
@endsection
