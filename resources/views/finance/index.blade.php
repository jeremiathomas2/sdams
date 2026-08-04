@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Finance <span>/ Contributions</span></div>
<div class="page-header">
    <div>
        <h2>💰 Contributions & Offerings</h2>
        <p>Manage church financial records</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap">
        <a href="{{ route('offerings.export') }}" class="btn btn-outline">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            Export CSV
        </a>
        <a href="{{ route('offerings.create') }}" class="btn btn-primary-solid">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Record Offering
        </a>
    </div>
</div>

<div class="card" style="margin-bottom:16px">
    <form action="{{ request()->url() }}" method="GET" autocomplete="off">
        <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:center">
            <div style="flex:1;min-width:220px;position:relative">
                <svg style="position:absolute;left:11px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:var(--text-muted)" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="q" class="form-control" value="{{ request('q') }}" placeholder="Search by member, member ID, receipt # or notes..." style="padding-left:36px">
            </div>
            <select name="type" class="form-control" style="width:180px">
                <option value="">All Types</option>
                @foreach($types as $type)
                <option value="{{ $type }}" @selected(request('type') === $type)>{{ $type }}</option>
                @endforeach
            </select>
            <select name="fund" class="form-control" style="width:180px">
                <option value="">All Funds</option>
                @foreach($funds as $fund)
                <option value="{{ $fund->id }}" @selected(request('fund') !== null && (string) request('fund') === (string) $fund->id)>{{ $fund->name }}</option>
                @endforeach
            </select>
            <label style="display:flex;align-items:center;gap:6px;font-size:14px;cursor:pointer">
                <input type="checkbox" name="has_receipt" value="1" @checked(request()->boolean('has_receipt'))>
                Has receipt
            </label>
            <button type="submit" class="btn btn-accent">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                Filter
            </button>
            <a href="{{ request()->url() }}" class="btn btn-ghost">Reset</a>
        </div>

        <details style="margin-top:12px">
            <summary style="cursor:pointer;font-size:14px;color:var(--text-muted)">Advanced filters (date &amp; amount)</summary>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px;margin-top:12px">
                <div class="form-group-app" style="margin-bottom:0">
                    <label class="form-label-app">Date from</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="form-group-app" style="margin-bottom:0">
                    <label class="form-label-app">Date to</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="form-group-app" style="margin-bottom:0">
                    <label class="form-label-app">Min amount (TZS)</label>
                    <input type="number" name="amount_min" class="form-control" value="{{ request('amount_min') }}" min="0" step="any">
                </div>
                <div class="form-group-app" style="margin-bottom:0">
                    <label class="form-label-app">Max amount (TZS)</label>
                    <input type="number" name="amount_max" class="form-control" value="{{ request('amount_max') }}" min="0" step="any">
                </div>
            </div>
        </details>
    </form>
</div>

@if(isset($summary))
<div style="display:flex;gap:24px;flex-wrap:wrap;align-items:center;margin-bottom:12px;font-size:14px">
    <span><strong style="font-size:18px">{{ number_format($summary->count) }}</strong> {{ $summary->count == 1 ? 'record' : 'records' }} found</span>
    <span>Total: <strong style="font-size:18px">TZS {{ number_format($summary->total, 2) }}</strong></span>
</div>
@endif

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
                @forelse($offerings as $offering)
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
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:28px;color:var(--text-muted)">No offerings match your filters.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:20px">
        {{ $offerings->links() }}
    </div>
</div>
@endsection
