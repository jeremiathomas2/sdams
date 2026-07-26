@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Administration / Users <span>/ View</span></div>
<div class="page-header">
    <div>
        <h2>👤 User Details</h2>
        <p>Full account information</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap">
        <a href="{{ route('users.index') }}" class="btn btn-outline">Back</a>
    </div>
</div>

<div class="card">
    <div style="display:flex;align-items:center;gap:12px;margin-bottom:18px">
        <div class="member-avatar" style="width:44px;height:44px;font-size:1rem">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
        <div>
            <div style="font-weight:800;font-size:1.05rem">{{ $user->name }}</div>
            <div style="color:var(--text-muted);font-size:0.85rem">{{ $user->email }}</div>
        </div>
    </div>

    <div class="grid-2">
        <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Role</div>
            <div style="font-weight:800">{{ $user->role }}</div>
        </div>
        <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Email Verification</div>
            <div style="font-weight:800">
                @if ($user->email_verified_at)
                    Verified ({{ $user->email_verified_at->format('M d, Y H:i') }})
                @else
                    Not verified
                @endif
            </div>
        </div>
    </div>

    <div class="grid-2" style="margin-top:12px">
        <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Created</div>
            <div style="font-weight:800">{{ $user->created_at?->format('M d, Y H:i') ?? '-' }}</div>
        </div>
        <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Last Updated</div>
            <div style="font-weight:800">{{ $user->updated_at?->format('M d, Y H:i') ?? '-' }}</div>
        </div>
    </div>

    <div style="margin-top:12px;padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
        <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">User ID</div>
        <div style="font-weight:800">{{ $user->id }}</div>
    </div>
</div>
@endsection
