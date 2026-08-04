@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Administration <span>/ Create User</span></div>
<div class="page-header">
    <div>
        <h2>👤 Create New User</h2>
        <p>Add a new user account to the system</p>
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
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">Role</label>
                <select name="role" class="form-control" required>
                    <option value="Administrator" {{ old('role') == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                    <option value="Pastor" {{ old('role') == 'Pastor' ? 'selected' : '' }}>Pastor</option>
                    <option value="Finance Clerk" {{ old('role') == 'Finance Clerk' ? 'selected' : '' }}>Finance Clerk</option>
                    <option value="Membership Clerk" {{ old('role') == 'Membership Clerk' ? 'selected' : '' }}>Membership Clerk</option>
                    <option value="Member" {{ old('role') == 'Member' ? 'selected' : '' }}>Member</option>
                </select>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Link to Member (Membership Number)</label>
                <select name="member_id" class="form-control">
                    <option value="">— Not linked —</option>
                    @foreach($members as $member)
                    <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                        {{ $member->member_id }} · {{ $member->full_name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">Profile Picture (optional)</label>
                <input type="file" name="profile_photo" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                <div style="font-size:0.75rem;color:var(--text-muted);margin-top:4px">JPG, PNG, GIF or WebP · max 2MB</div>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Password</label>
                <input type="password" name="password" class="form-control" required minlength="8">
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px">
            <a href="{{ route('users.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary-solid">Create User</button>
        </div>
    </form>
</div>
@endsection
