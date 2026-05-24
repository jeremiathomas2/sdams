@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Membership <span>/ Transfers</span></div>
<div class="page-header">
    <div>
        <h2>🔄 Member Transfers</h2>
        <p>Manage membership transfers in and out of the church</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap">
        <a href="{{ route('transfers.create') }}" class="btn btn-primary-solid">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            New Transfer
        </a>
    </div>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Member</th>
                    <th>Type</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transfers as $transfer)
                <tr>
                    <td>{{ $transfer->request_date }}</td>
                    <td>{{ $transfer->member->full_name }}</td>
                    <td>
                        <span class="badge {{ $transfer->type == 'In' ? 'badge-info' : 'badge-warning' }}">
                            Transfer {{ $transfer->type }}
                        </span>
                    </td>
                    <td>{{ $transfer->from_church }}</td>
                    <td>{{ $transfer->to_church }}</td>
                    <td>
                        <span class="badge {{ $transfer->status == 'Approved' ? 'badge-success' : ($transfer->status == 'Pending' ? 'badge-warning' : 'badge-danger') }}">
                            {{ $transfer->status }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:5px">
                            <a href="{{ route('transfers.edit', $transfer) }}" class="btn btn-ghost btn-sm" title="Edit/Review"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                            <form action="{{ route('transfers.destroy', $transfer) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-ghost btn-sm" style="color:var(--danger)"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top:20px">
        {{ $transfers->links() }}
    </div>
</div>
@endsection
