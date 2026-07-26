@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Administration <span>/ Audit Logs</span></div>
<div class="page-header">
    <div>
        <h2>📋 Audit Logs</h2>
        <p>Track system activity, user actions, and data changes</p>
    </div>
    <div style="display:flex;gap:10px">
        <a href="{{ route('users.auditExport', request()->query()) }}" class="btn btn-outline btn-sm">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Export CSV
        </a>
    </div>
</div>

<div class="stats-grid" style="grid-template-columns: repeat(4, 1fr)">
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(26,86,160,0.1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#1a56a0" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ number_format($stats['total']) }}</div>
            <div class="stat-label">{{ $hasFilters ? 'Matching Events' : 'Total Events' }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(22,163,74,0.1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ number_format($stats['today']) }}</div>
            <div class="stat-label">{{ $hasFilters ? 'Matching Today' : 'Today' }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(217,119,6,0.1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ number_format($stats['this_week']) }}</div>
            <div class="stat-label">{{ $hasFilters ? 'Matching This Week' : 'This Week' }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(8,145,178,0.1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#0891b2" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div>
            <div class="stat-val">{{ number_format($stats['unique_users']) }}</div>
            <div class="stat-label">{{ $hasFilters ? 'Users Involved' : 'Active Users' }}</div>
        </div>
    </div>
</div>

<div class="card" style="margin-bottom:20px">
    <form method="GET" action="{{ route('users.audit') }}">
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr 1fr auto;gap:12px;align-items:end">
            <div class="form-group-app" style="margin:0">
                <label class="form-label-app">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Description, model, user..." value="{{ $filters['search'] ?? '' }}">
            </div>
            <div class="form-group-app" style="margin:0">
                <label class="form-label-app">Action</label>
                <select name="action" class="form-control">
                    <option value="">All Actions</option>
                    <option value="created" {{ ($filters['action'] ?? '') == 'created' ? 'selected' : '' }}>Created</option>
                    <option value="updated" {{ ($filters['action'] ?? '') == 'updated' ? 'selected' : '' }}>Updated</option>
                    <option value="deleted" {{ ($filters['action'] ?? '') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                </select>
            </div>
            <div class="form-group-app" style="margin:0">
                <label class="form-label-app">Module</label>
                <select name="model" class="form-control">
                    <option value="">All Modules</option>
                    @foreach($allModels as $model)
                    <option value="{{ $model }}" {{ ($filters['model'] ?? '') == $model ? 'selected' : '' }}>{{ $model }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group-app" style="margin:0">
                <label class="form-label-app">User</label>
                <select name="user_id" class="form-control">
                    <option value="">All Users</option>
                    @foreach($allUsers as $id => $name)
                    <option value="{{ $id }}" {{ ($filters['user_id'] ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group-app" style="margin:0">
                <label class="form-label-app">Date Range</label>
                <div style="display:flex;gap:6px">
                    <input type="date" name="date_from" class="form-control" value="{{ $filters['date_from'] ?? '' }}" style="font-size:0.82rem">
                    <input type="date" name="date_to" class="form-control" value="{{ $filters['date_to'] ?? '' }}" style="font-size:0.82rem">
                </div>
            </div>
            <div style="display:flex;gap:6px;padding-bottom:2px">
                <button type="submit" class="btn btn-primary-solid btn-sm">Filter</button>
                @if($hasFilters)
                <a href="{{ route('users.audit') }}" class="btn btn-ghost btn-sm">Clear</a>
                @endif
            </div>
        </div>
    </form>
</div>

<div class="grid-2" style="margin-bottom:20px">
    <div class="card">
        <div class="card-title" style="margin-bottom:12px">{{ $hasFilters ? 'Filtered' : '' }} Activity by Action</div>
        <div style="display:flex;flex-direction:column;gap:10px">
            @php $maxAction = !empty($actionCounts) ? max($actionCounts) : 1; @endphp
            @foreach(['created' => 'Created', 'updated' => 'Updated', 'deleted' => 'Deleted'] as $key => $label)
            @php $count = $actionCounts[$key] ?? 0; @endphp
            <div>
                <div style="display:flex;justify-content:space-between;margin-bottom:4px">
                    <span style="font-size:0.82rem;font-weight:600">{{ $label }}</span>
                    <span style="font-size:0.82rem;color:var(--text-muted)">{{ number_format($count) }}</span>
                </div>
                <div style="height:8px;background:var(--bg);border-radius:99px;overflow:hidden">
                    <div style="height:100%;width:{{ $maxAction > 0 ? round(($count / $maxAction) * 100) : 0 }}%;background:{{ $key == 'created' ? 'var(--success)' : ($key == 'updated' ? 'var(--primary)' : 'var(--danger)') }};border-radius:99px;transition:width 0.5s"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="card">
        <div class="card-title" style="margin-bottom:12px">{{ $hasFilters ? 'Filtered' : '' }} Top Modules</div>
        <div style="display:flex;flex-direction:column;gap:10px">
            @php $maxModel = !empty($modelCounts) ? max($modelCounts) : 1; @endphp
            @foreach(array_slice($modelCounts, 0, 5, true) as $model => $count)
            <div>
                <div style="display:flex;justify-content:space-between;margin-bottom:4px">
                    <span style="font-size:0.82rem;font-weight:600">{{ $model }}</span>
                    <span style="font-size:0.82rem;color:var(--text-muted)">{{ number_format($count) }}</span>
                </div>
                <div style="height:8px;background:var(--bg);border-radius:99px;overflow:hidden">
                    <div style="height:100%;width:{{ $maxModel > 0 ? round(($count / $maxModel) * 100) : 0 }}%;background:var(--accent);border-radius:99px;transition:width 0.5s"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="card">
    @if($logs->count())
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:40px"></th>
                    <th>Timestamp</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Module</th>
                    <th>Description</th>
                    <th>IP Address</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr class="audit-row" data-id="{{ $log->id }}" style="cursor:pointer">
                    <td style="text-align:center;color:var(--text-muted);font-size:0.75rem">
                        @if($log->old_values || $log->new_values)
                        <svg class="expand-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="transition:transform 0.2s"><polyline points="6 9 12 15 18 9"/></svg>
                        @else
                        <span style="opacity:0.3">—</span>
                        @endif
                    </td>
                    <td>
                        <div style="font-size:0.82rem">{{ $log->created_at->format('M d, Y') }}</div>
                        <div style="font-size:0.75rem;color:var(--text-muted)">{{ $log->created_at->format('H:i:s') }}</div>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px">
                            <div class="member-avatar" style="width:30px;height:30px;font-size:0.7rem">{{ substr($log->user->name ?? 'S', 0, 1) }}</div>
                            <div>
                                <div style="font-weight:600;font-size:0.85rem">{{ $log->user->name ?? 'System' }}</div>
                                @if($log->user)
                                <div style="font-size:0.72rem;color:var(--text-muted)">{{ $log->user->role ?? '' }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td><span class="badge badge-{{ $log->action_color }}">{{ ucfirst($log->action) }}</span></td>
                    <td><span style="font-weight:600;font-size:0.85rem">{{ $log->model }}</span>@if($log->model_id) <span style="font-size:0.75rem;color:var(--text-muted)">#{{ $log->model_id }}</span>@endif</td>
                    <td style="max-width:260px">
                        <div style="font-size:0.82rem;color:var(--text-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $log->description ?? $log->diff_text }}</div>
                    </td>
                    <td style="font-size:0.78rem;color:var(--text-muted);font-family:monospace">{{ $log->ip_address ?? '—' }}</td>
                </tr>
                @if($log->old_values || $log->new_values)
                <tr class="audit-detail" id="detail-{{ $log->id }}" style="display:none">
                    <td colspan="7" style="padding:0;border-bottom:1px solid var(--border)">
                        <div style="padding:14px 20px;background:var(--bg);border-radius:0 0 var(--radius-lg) var(--radius-lg)">
                            <div style="font-size:0.78rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px">Change Details</div>
                            @if($log->old_values && $log->new_values)
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                                <div>
                                    <div style="font-size:0.75rem;font-weight:700;color:#dc2626;margin-bottom:6px">Previous Values</div>
                                    <div style="background:var(--card);border:1px solid var(--border);border-radius:8px;padding:10px;font-size:0.8rem">
                                        @foreach($log->old_values as $key => $value)
                                        <div style="padding:3px 0;border-bottom:1px solid var(--border)">
                                            <span style="font-weight:600">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                            <span style="color:var(--text-muted)">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div>
                                    <div style="font-size:0.75rem;font-weight:700;color:#16a34a;margin-bottom:6px">New Values</div>
                                    <div style="background:var(--card);border:1px solid var(--border);border-radius:8px;padding:10px;font-size:0.8rem">
                                        @foreach($log->new_values as $key => $value)
                                        <div style="padding:3px 0;border-bottom:1px solid var(--border)">
                                            <span style="font-weight:600">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                            <span style="color:var(--text-muted)">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @elseif($log->new_values)
                            <div style="max-width:500px">
                                <div style="font-size:0.75rem;font-weight:700;color:#16a34a;margin-bottom:6px">Created Values</div>
                                <div style="background:var(--card);border:1px solid var(--border);border-radius:8px;padding:10px;font-size:0.8rem">
                                    @foreach($log->new_values as $key => $value)
                                    <div style="padding:3px 0;border-bottom:1px solid var(--border)">
                                        <span style="font-weight:600">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                        <span style="color:var(--text-muted)">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            <div style="margin-top:8px;font-size:0.72rem;color:var(--text-muted)">
                                ID: {{ $log->model_id }} | Created: {{ $log->created_at->format('M d, Y H:i:s') }}
                            </div>
                        </div>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="pager">
        <div class="pager-info">
            Showing {{ $logs->firstItem() }}–{{ $logs->lastItem() }} of {{ $logs->total() }} logs
        </div>
        <div>
            {{ $logs->links() }}
        </div>
    </div>
    @else
    <div style="text-align:center;padding:50px;color:var(--text-muted)">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom:12px;opacity:0.4"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        <p style="font-weight:600;margin-bottom:4px">No audit logs found</p>
        <p style="font-size:0.85rem">{{ $hasFilters ? 'Try adjusting your filters.' : 'Activity will appear here as users interact with the system.' }}</p>
    </div>
    @endif
</div>

<script>
document.querySelectorAll('.audit-row').forEach(function(row) {
    row.addEventListener('click', function() {
        var id = this.getAttribute('data-id');
        var detail = document.getElementById('detail-' + id);
        if (!detail) return;
        var icon = this.querySelector('.expand-icon');
        if (detail.style.display === 'none') {
            detail.style.display = '';
            if (icon) icon.style.transform = 'rotate(180deg)';
            this.style.background = 'var(--bg)';
        } else {
            detail.style.display = 'none';
            if (icon) icon.style.transform = '';
            this.style.background = '';
        }
    });
});
</script>
@endsection
