@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Administration <span>/ Roles & Permissions</span></div>
<div class="page-header">
    <div>
        <h2>🛡️ Roles & Permissions</h2>
        <p>Define what different system users can access</p>
    </div>
</div>

<div class="grid-auto">
    <div class="card">
        <h3 class="card-title">Administrator</h3>
        <p class="card-sub" style="margin-bottom:15px">Full system access, including user management and system settings.</p>
        <ul style="font-size:0.85rem;color:var(--text-muted);list-style:none;padding:0;margin-bottom:20px">
            <li style="display:flex;align-items:center;gap:8px;margin-bottom:5px"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Membership Full Access</li>
            <li style="display:flex;align-items:center;gap:8px;margin-bottom:5px"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Finance Full Access</li>
            <li style="display:flex;align-items:center;gap:8px;margin-bottom:5px"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> System Administration</li>
        </ul>
        <button class="btn btn-outline btn-sm" style="width:100%">Edit Permissions</button>
    </div>

    <div class="card">
        <h3 class="card-title">Finance Clerk</h3>
        <p class="card-sub" style="margin-bottom:15px">Can manage offerings, tithes, and view financial reports.</p>
        <ul style="font-size:0.85rem;color:var(--text-muted);list-style:none;padding:0;margin-bottom:20px">
            <li style="display:flex;align-items:center;gap:8px;margin-bottom:5px"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Finance Management</li>
            <li style="display:flex;align-items:center;gap:8px;margin-bottom:5px"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> View Membership</li>
            <li style="display:flex;align-items:center;gap:8px;margin-bottom:5px"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--danger)" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> System Settings</li>
        </ul>
        <button class="btn btn-outline btn-sm" style="width:100%">Edit Permissions</button>
    </div>

    <div class="card">
        <h3 class="card-title">Membership Clerk</h3>
        <p class="card-sub" style="margin-bottom:15px">Can manage member records and transfer requests.</p>
        <ul style="font-size:0.85rem;color:var(--text-muted);list-style:none;padding:0;margin-bottom:20px">
            <li style="display:flex;align-items:center;gap:8px;margin-bottom:5px"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Member Management</li>
            <li style="display:flex;align-items:center;gap:8px;margin-bottom:5px"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--success)" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Transfer Requests</li>
            <li style="display:flex;align-items:center;gap:8px;margin-bottom:5px"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--danger)" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Finance Management</li>
        </ul>
        <button class="btn btn-outline btn-sm" style="width:100%">Edit Permissions</button>
    </div>
</div>
@endsection
