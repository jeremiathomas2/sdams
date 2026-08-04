@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Administration <span>/ Roles & Permissions</span></div>
<div class="page-header">
    <div>
        <h2>🛡️ Roles & Permissions</h2>
        <p>Create roles, then grant or revoke what each role can access</p>
    </div>
    <div style="display:flex;gap:10px;align-items:center">
        <a href="{{ route('users.index') }}" class="btn btn-ghost btn-sm">Back to Users</a>
        <button class="btn btn-primary-solid btn-sm" onclick="document.getElementById('createRoleModal').classList.add('open')">
            <span style="margin-right:4px">＋</span> New Role
        </button>
    </div>
</div>

@if ($errors->any())
<div class="alert alert-danger" style="margin-bottom:16px">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <div>
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
</div>
@endif

@if($roles->isEmpty())
<div class="card" style="text-align:center;padding:60px 30px">
    <div style="font-size:2rem;margin-bottom:12px">🛡️</div>
    <h3 style="margin-bottom:8px">No roles yet</h3>
    <p style="color:var(--text-muted);max-width:420px;margin:0 auto 20px">Create your first role to start granting access. Permission checks fall back to the built-in roles until roles are seeded.</p>
    <button class="btn btn-primary-solid" onclick="document.getElementById('createRoleModal').classList.add('open')">＋ Create Role</button>
</div>
@else
<div class="roles-layout">

    <aside class="roles-side">
        <div class="roles-tabs">
            @foreach($roles as $role)
            <button type="button" class="role-tab {{ $loop->first ? 'active' : '' }}" data-role-id="{{ $role->id }}" onclick="selectRole(this)">
                <span class="role-tab-name">{{ $role->display_name }}</span>
                <span class="badge {{ $role->user_count > 0 ? 'badge-info' : 'badge-secondary' }}">{{ $role->user_count }}</span>
            </button>
            @endforeach
        </div>
        <div style="margin-top:14px;padding:0 4px;font-size:0.78rem;color:var(--text-muted)">
            Badge shows how many users currently hold the role.
        </div>
    </aside>

    <div class="roles-main">
        @foreach($roles as $role)
        @php($granted = $role->permissions->pluck('id')->all())
        <section class="card role-panel {{ $loop->first ? 'active' : '' }}" id="role-panel-{{ $role->id }}">

            <div class="role-panel-header">
                <div>
                    <h3 class="card-title" style="font-size:1.15rem">{{ $role->display_name }}</h3>
                    <p class="card-sub">{{ $role->description ?: 'No description provided.' }}</p>
                    <div style="margin-top:6px;font-size:0.8rem;color:var(--text-muted)">
                        {{ $role->user_count }} user(s) · {{ $role->permissions->count() }} permission(s) granted
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-shrink:0">
                    <button type="button" class="btn btn-outline btn-sm"
                        data-edit-name="{{ $role->name }}"
                        data-edit-label="{{ $role->label }}"
                        data-edit-desc="{{ $role->description }}"
                        data-edit-action="{{ route('roles.update', $role) }}"
                        data-edit-locked="{{ ($role->name === 'Administrator' || $role->user_count > 0) ? '1' : '0' }}"
                        onclick="openEditRole(this)">Edit</button>
                    @if($role->name !== 'Administrator' && $role->user_count === 0)
                    <form method="POST" action="{{ route('roles.destroy', $role) }}" onsubmit="return confirm('Delete role &quot;{{ $role->name }}&quot;? This cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button>
                    </form>
                    @endif
                </div>
            </div>

            @if($role->name === 'Administrator')
            <div class="alert alert-info" style="margin-top:14px">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <div>The Administrator role always has full system access, regardless of the permissions below.</div>
            </div>
            @endif

            <form method="POST" action="{{ route('roles.permissions', $role) }}" class="perms-form">
                @csrf
                @method('PUT')

                @foreach($permissionGroups as $module => $permissions)
                <div class="perm-group">
                    <div class="perm-group-header">
                        <span class="perm-group-title">{{ $module }}</span>
                        <span style="display:flex;align-items:center;gap:8px;font-size:0.78rem;color:var(--text-muted)">
                            Grant all
                            <label class="toggle" style="margin:0">
                                <input type="checkbox" class="module-toggle" data-module="{{ $module }}" onchange="toggleModulePerms(this)">
                                <span class="toggle-slider"></span>
                            </label>
                        </span>
                    </div>
                    <div class="perm-group-body">
                        @foreach($permissions as $permName => $permLabel)
                        @php($perm = $allPermissions->firstWhere('name', $permName))
                        @if(!$perm) @continue @endif
                        <div class="perm-row">
                            <div style="min-width:0">
                                <div class="perm-label">{{ $permLabel }}</div>
                                <div class="perm-name">{{ $permName }}</div>
                            </div>
                            <label class="toggle" style="flex-shrink:0">
                                <input type="checkbox" class="perm-toggle" data-module="{{ $module }}"
                                    name="permissions[]" value="{{ $perm->id }}"
                                    {{ in_array($perm->id, $granted) ? 'checked' : '' }}
                                    onchange="refreshModuleCheckbox(this.dataset.module)">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <div style="display:flex;justify-content:flex-end;margin-top:22px;gap:10px">
                    <button type="submit" class="btn btn-primary-solid">Save Permissions</button>
                </div>
            </form>
        </section>
        @endforeach
    </div>
</div>
@endif
@endsection

@section('modals')
<div class="modal-overlay" id="createRoleModal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Create Role</div>
            <button class="modal-close" type="button" onclick="closeModal('createRoleModal')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('roles.store') }}">
            @csrf
            <div class="modal-body">
                <div class="form-group-app">
                    <label class="form-label-app">Role Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Youth Leader" required>
                    <div style="font-size:0.75rem;color:var(--text-muted);margin-top:4px">Used internally and shown in the user role dropdown. Must be unique.</div>
                </div>
                <div class="form-group-app">
                    <label class="form-label-app">Display Name <span style="color:var(--text-muted);font-weight:400">(optional)</span></label>
                    <input type="text" name="label" class="form-control" value="{{ old('label') }}" placeholder="e.g. Youth Leader">
                </div>
                <div class="form-group-app" style="margin-bottom:0">
                    <label class="form-label-app">Description</label>
                    <textarea name="description" class="form-control" placeholder="What can users with this role do?">{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="closeModal('createRoleModal')">Cancel</button>
                <button type="submit" class="btn btn-primary-solid">Create Role</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="editRoleModal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">Edit Role</div>
            <button class="modal-close" type="button" onclick="closeModal('editRoleModal')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form method="POST" action="#" id="editRoleForm">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group-app">
                    <label class="form-label-app">Role Name</label>
                    <input type="text" name="name" id="editRoleName" class="form-control" required>
                    <div style="font-size:0.75rem;color:var(--text-muted);margin-top:4px" id="editRoleNameHint">The name cannot be changed while the role has assigned users.</div>
                </div>
                <div class="form-group-app">
                    <label class="form-label-app">Display Name <span style="color:var(--text-muted);font-weight:400">(optional)</span></label>
                    <input type="text" name="label" id="editRoleLabel" class="form-control">
                </div>
                <div class="form-group-app" style="margin-bottom:0">
                    <label class="form-label-app">Description</label>
                    <textarea name="description" id="editRoleDesc" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="closeModal('editRoleModal')">Cancel</button>
                <button type="submit" class="btn btn-primary-solid">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        window.selectRole = function (el) {
            const id = el.dataset.roleId;
            document.querySelectorAll('.role-tab').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
            document.querySelectorAll('.role-panel').forEach(p => p.classList.remove('active'));
            const panel = document.getElementById('role-panel-' + id);
            if (panel) panel.classList.add('active');
        };

        window.refreshModuleCheckbox = function (module) {
            const toggles = Array.prototype.slice.call(document.querySelectorAll('.perm-toggle[data-module="' + module + '"]'));
            const moduleCb = document.querySelector('.module-toggle[data-module="' + module + '"]');
            if (!moduleCb || !toggles.length) return;
            const allOn = toggles.every(t => t.checked);
            const someOn = toggles.some(t => t.checked);
            moduleCb.checked = allOn;
            moduleCb.indeterminate = someOn && !allOn;
        };

        window.toggleModulePerms = function (cb) {
            const module = cb.dataset.module;
            document.querySelectorAll('.perm-toggle[data-module="' + module + '"]').forEach(t => {
                t.checked = cb.checked;
            });
            cb.indeterminate = false;
        };

        window.openEditRole = function (el) {
            document.getElementById('editRoleName').value = el.dataset.editName;
            document.getElementById('editRoleLabel').value = el.dataset.editLabel || '';
            document.getElementById('editRoleDesc').value = el.dataset.editDesc || '';
            document.getElementById('editRoleForm').action = el.dataset.editAction;

            const nameInput = document.getElementById('editRoleName');
            const locked = el.dataset.editLocked === '1';
            nameInput.disabled = locked;
            nameInput.style.background = locked ? 'var(--bg)' : '';
            document.getElementById('editRoleNameHint').textContent = locked
                ? 'The name cannot be changed while the role has assigned users.'
                : 'Changing the name affects the user role dropdown and permission checks.';

            document.getElementById('editRoleModal').classList.add('open');
        };

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.perm-group').forEach(function (group) {
                const module = group.querySelector('.module-toggle').dataset.module;
                refreshModuleCheckbox(module);
            });
        });
    })();
</script>
@endpush
