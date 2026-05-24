@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Members <span>/ All Members</span></div>
<div class="page-header">
    <div>
        <h2>👥 All Members</h2>
        <p>{{ $members->total() }} total members in the database</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap">
        <button class="btn btn-outline" onclick="showToast('Export','Members list exported to CSV.','success')">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            Export CSV
        </button>
        <a href="{{ route('members.create') }}" class="btn btn-primary-solid">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Member
        </a>
    </div>
</div>

<div class="card" style="margin-bottom:16px">
    <form action="{{ route('members.search') }}" method="GET" style="display:flex;gap:12px;flex-wrap:wrap;align-items:center">
        <div style="flex:1;min-width:200px;position:relative">
            <svg style="position:absolute;left:11px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:var(--text-muted)" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="query" class="form-control" placeholder="Search by name, ID or phone..." style="padding-left:36px">
        </div>
        <select name="status" class="form-control" style="width:150px">
            <option value="">All Status</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
            <option value="Probation">Probation</option>
        </select>
        <button type="submit" class="btn btn-accent">Filter</button>
    </form>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Member ID</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                <tr>
                    <td><code>{{ $member->member_id }}</code></td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px">
                            <div class="member-avatar">{{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}</div>
                            {{ $member->full_name }}
                        </div>
                    </td>
                    <td>{{ $member->gender }}</td>
                    <td>{{ $member->phone_number }}</td>
                    <td>
                        <span class="badge {{ $member->membership_status == 'Active' ? 'badge-success' : 'badge-warning' }}">
                            {{ $member->membership_status }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:5px">
                            <a href="{{ route('members.show', $member) }}" class="btn btn-ghost btn-sm" title="View"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></a>
                            <a href="{{ route('members.edit', $member) }}" class="btn btn-ghost btn-sm" title="Edit"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                            <form action="{{ route('members.destroy', $member) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-ghost btn-sm" style="color:var(--danger)" title="Delete"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top:20px">
        {{ $members->links() }}
    </div>
</div>
@endsection
