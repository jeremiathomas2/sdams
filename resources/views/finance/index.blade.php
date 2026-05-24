@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Finance <span>/ Contributions</span></div>
<div class="page-header">
    <div>
        <h2>💰 Contributions & Offerings</h2>
        <p>Manage church financial records</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap">
        <a href="{{ route('offerings.create') }}" class="btn btn-primary-solid">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Record Offering
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
                    <th>Amount (TZS)</th>
                    <th>Receipt #</th>
                    <th>Fund</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($offerings as $offering)
                <tr>
                    <td>{{ $offering->date }}</td>
                    <td>{{ $offering->member->full_name }}</td>
                    <td><span class="badge badge-info">{{ $offering->type }}</span></td>
                    <td><strong>{{ number_format($offering->amount, 2) }}</strong></td>
                    <td>{{ $offering->receipt_number ?? '-' }}</td>
                    <td>{{ $offering->fund->name ?? '-' }}</td>
                    <td>
                        <div style="display:flex;gap:5px">
                            <a href="{{ route('offerings.edit', $offering) }}" class="btn btn-ghost btn-sm"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                            <form action="{{ route('offerings.destroy', $offering) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
        {{ $offerings->links() }}
    </div>
</div>
@endsection
