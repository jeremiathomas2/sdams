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
    <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
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

        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">Role</label>
                <select name="role" class="form-control" required>
                    @php($roleValue = old('role', $user->role))
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ $roleValue == $role->name ? 'selected' : '' }}>{{ $role->display_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Link to Member (Membership Number)</label>
                <select name="member_id" class="form-control">
                    <option value="">— Not linked —</option>
                    @foreach($members as $member)
                    <option value="{{ $member->id }}" {{ old('member_id', $user->member_id) == $member->id ? 'selected' : '' }}>
                        {{ $member->member_id }} · {{ $member->full_name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid-2">
            <div class="form-group-app">
                <label class="form-label-app">Profile Picture</label>
                <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
                    @include('partials.avatar', ['entity' => $user, 'size' => 44, 'fontSize' => '1rem'])
                    <div style="flex:1;min-width:180px">
                        <input type="file" name="profile_photo" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                        <div style="display:flex;align-items:center;gap:8px;margin-top:6px">
                            @if($user->has_photo)
                            <label style="display:flex;align-items:center;gap:6px;font-size:0.8rem;color:var(--danger);cursor:pointer">
                                <input type="checkbox" name="remove_photo" value="1" {{ old('remove_photo') ? 'checked' : '' }}>
                                Remove current photo
                            </label>
                            @endif
                            <span style="font-size:0.75rem;color:var(--text-muted)">JPG, PNG, GIF or WebP · max 2MB</span>
                        </div>
                    </div>
                </div>
            </div>
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
