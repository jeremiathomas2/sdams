@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home <span>/ My Profile</span></div>
<div class="page-header">
    <div>
        <h2>👤 My Profile</h2>
        <p>Manage your profile information and profile picture</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap">
        <a href="{{ route('dashboard') }}" class="btn btn-outline">Back to Dashboard</a>
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
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display:flex;gap:24px;flex-wrap:wrap;align-items:flex-start">
            <div style="text-align:center;flex-shrink:0">
                <div class="profile-avatar-wrap" style="width:120px;height:120px">
                    @include('partials.avatar', [
                        'entity' => $user,
                        'size' => 120,
                        'fontSize' => '2.2rem',
                        'extraStyle' => 'border:3px solid var(--border)',
                    ])
                </div>
                <div style="margin-top:12px">
                    <label class="btn btn-outline btn-sm" style="cursor:pointer;margin-bottom:6px">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        Choose Photo
                        <input type="file" name="profile_photo" id="profilePhotoInput" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" style="display:none">
                    </label>
                    @if($user->has_photo)
                    <div>
                        <label class="btn btn-ghost btn-sm remove-photo-label" style="cursor:pointer;color:var(--danger)">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            Remove Photo
                            <input type="checkbox" name="remove_photo" value="1" style="display:none">
                        </label>
                    </div>
                    @endif
                    <div style="font-size:0.75rem;color:var(--text-muted);margin-top:6px">JPG, PNG, GIF or WebP · max 2MB</div>
                </div>
            </div>

            <div style="flex:1;min-width:280px">
                <div class="grid-2">
                    <div class="form-group-app">
                        <label class="form-label-app">Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="form-group-app">
                        <label class="form-label-app">Email Address</label>
                        <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group-app">
                        <label class="form-label-app">Role</label>
                        <input type="text" class="form-control" value="{{ $user->role }}" disabled>
                    </div>
                    <div class="form-group-app">
                        <label class="form-label-app">Membership Number</label>
                        <div style="display:flex;align-items:center;gap:8px">
                            <code style="font-size:0.95rem;padding:7px 12px;background:rgba(26,86,160,0.08);border-radius:8px;color:var(--primary)">{{ $user->member_id_display }}</code>
                            @if($user->member)
                            <a href="{{ route('members.show', $user->member) }}" class="btn btn-ghost btn-sm" title="View Member Profile">View →</a>
                            @endif
                        </div>
                    </div>
                </div>

                @if($user->member)
                <div class="grid-2">
                    <div class="form-group-app">
                        <label class="form-label-app">Phone (from member record)</label>
                        <input type="text" class="form-control" value="{{ $user->member->phone_number ?? '—' }}" disabled>
                    </div>
                    <div class="form-group-app">
                        <label class="form-label-app">Department/Ministry</label>
                        <input type="text" class="form-control" value="{{ $user->member->department_ministry ?? 'Not assigned' }}" disabled>
                    </div>
                </div>
                @endif

                <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:20px">
                    <a href="{{ route('dashboard') }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary-solid">Save Profile</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('profilePhotoInput');
        if (!input) return;
        const removeLabel = document.querySelector('.remove-photo-label');
        if (removeLabel) {
            const checkbox = removeLabel.querySelector('input[name="remove_photo"]');
            if (checkbox) {
                checkbox.addEventListener('change', function () {
                    removeLabel.style.textDecoration = this.checked ? 'line-through' : 'none';
                    removeLabel.style.opacity = this.checked ? '0.6' : '1';
                });
            }
        }
        input.addEventListener('change', function () {
            const file = this.files && this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function (e) {
                const wrap = document.querySelector('.profile-avatar-wrap');
                if (!wrap) return;
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Profile Preview';
                img.style.cssText = 'width:120px;height:120px;border-radius:50%;object-fit:cover;border:3px solid var(--border);box-shadow:var(--shadow-lg)';
                wrap.innerHTML = '';
                wrap.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endpush
