@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Administration <span>/ Edit User</span></div>
<div class="page-header">
    <div>
        <h2>✏️ Edit User</h2>
        <p>Update user account for {{ $user->name }}</p>
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
    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
        </div>

        <div class="form-group-app">
            <label class="form-label-app">Role</label>
            <select name="role" class="form-control" required>
                @php($roleValue = old('role', $user->role))
                <option value="Administrator" {{ $roleValue == 'Administrator' ? 'selected' : '' }}>Administrator</option>
                <option value="Pastor" {{ $roleValue == 'Pastor' ? 'selected' : '' }}>Pastor</option>
                <option value="Finance Clerk" {{ $roleValue == 'Finance Clerk' ? 'selected' : '' }}>Finance Clerk</option>
                <option value="Membership Clerk" {{ $roleValue == 'Membership Clerk' ? 'selected' : '' }}>Membership Clerk</option>
                <option value="Member" {{ $roleValue == 'Member' ? 'selected' : '' }}>Member</option>
            </select>
        </div>

        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">New Password (leave blank to keep current)</label>
                <input type="password" name="password" class="form-control" minlength="8">
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px">
            <a href="{{ route('users.index') }}" class="btn btn-ghost">Cancel</a>
            <button type="submit" class="btn btn-primary-solid">Update User</button>
        </div>
    </form>
</div>
@endsection
