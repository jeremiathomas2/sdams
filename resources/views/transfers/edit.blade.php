@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Transfers <span>/ Review Transfer</span></div>
<div class="page-header">
    <div>
        <h2>✏️ Review Transfer Request</h2>
        <p>Review and update transfer for {{ $transfer->member->full_name }}</p>
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
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:18px">
        @include('partials.avatar', ['entity' => $transfer->member, 'size' => 44, 'fontSize' => '1rem'])
        <div>
            <div style="font-weight:800;font-size:1.05rem">{{ $transfer->member->full_name }}</div>
            <div style="color:var(--text-muted);font-size:0.85rem">{{ $transfer->member->member_id }}</div>
        </div>
    </div>

    <form action="{{ route('transfers.update', $transfer) }}" method="POST">
        @csrf
        @method('PUT')

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

        @if($transfer->notes)
        <div style="margin-top:12px;padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Notes</div>
            <div style="font-weight:800">{{ $transfer->notes }}</div>
        </div>
        @endif

        <div style="margin-top:20px;border-top:1px solid var(--border);padding-top:20px">
            <div class="card-title" style="margin-bottom:16px">Approval Decision</div>

            <div class="grid-2">
                <div class="form-group-app">
                    <label class="form-label-app">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Pending" {{ $transfer->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Approved" {{ $transfer->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Rejected" {{ $transfer->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="form-group-app">
                    <label class="form-label-app">Approval Date</label>
                    <input type="date" name="approval_date" class="form-control" value="{{ old('approval_date', $transfer->approval_date ? \Carbon\Carbon::parse($transfer->approval_date)->format('Y-m-d') : date('Y-m-d')) }}">
                </div>
            </div>

            <div class="form-group-app">
                <label class="form-label-app">Additional Notes</label>
                <textarea name="notes" class="form-control" placeholder="Any comments or remarks...">{{ old('notes', $transfer->notes) }}</textarea>
            </div>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px">
            <a href="{{ route('transfers.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary-solid">Update Transfer</button>
        </div>
    </form>
</div>
@endsection
