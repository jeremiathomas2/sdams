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
    <div style="display:flex;align-items:center;gap:16px;margin-bottom:18px;flex-wrap:wrap">
        @include('partials.avatar', ['entity' => $user, 'size' => 64, 'fontSize' => '1.3rem', 'extraStyle' => 'border:2px solid var(--border)'])
        <div style="flex:1;min-width:200px">
            <div style="font-weight:800;font-size:1.15rem">{{ $user->name }}</div>
            <div style="color:var(--text-muted);font-size:0.85rem">{{ $user->email }}</div>
            <div style="margin-top:6px">
                <span class="badge badge-info">{{ $user->role }}</span>
                @if($user->member)
                <a href="{{ route('members.show', $user->member) }}" class="badge badge-success" style="text-decoration:none">
                    Member ID: {{ $user->member->member_id }}
                </a>
                @else
                <span class="badge" style="background:var(--bg);color:var(--text-muted)">Member ID: Not linked</span>
                @endif
            </div>
        </div>
    </div>

    <div class="grid-2">
        <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Role</div>
            <div style="font-weight:800">{{ $user->role }}</div>
        </div>
        <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Membership Number</div>
            <div style="font-weight:800">
                @if($user->member)
                    <code style="color:var(--primary)">{{ $user->member->member_id }}</code>
                @else
                    <span style="color:var(--text-muted)">Not linked</span>
                @endif
            </div>
        </div>
    </div>

    <div class="grid-2" style="margin-top:12px">
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
        @if($user->member)
        <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Linked Member</div>
            <div style="font-weight:800">
                <a href="{{ route('members.show', $user->member) }}" style="text-decoration:none">{{ $user->member->full_name }}</a>
            </div>
        </div>
        @else
        <div style="padding:14px 16px;border:1px solid var(--border);border-radius:12px;background:var(--bg)">
            <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:6px">Linked Member</div>
            <div style="font-weight:800;color:var(--text-muted)">None</div>
        </div>
        @endif
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
