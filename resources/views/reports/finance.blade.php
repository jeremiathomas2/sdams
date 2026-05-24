@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Reports <span>/ Finance</span></div>
<div class="page-header">
    <div>
        <h2>📊 Finance Reports</h2>
        <p>Detailed financial overview of church contributions</p>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(22,163,74,0.1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div>
            <div class="stat-val">TZS {{ number_format($totalOfferings, 2) }}</div>
            <div class="stat-label">Total Contributions</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(26,86,160,0.1)">
            <svg viewBox="0 0 24 24" fill="none" stroke="#1a56a0" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div>
            <div class="stat-val">TZS {{ number_format($monthlyOfferings, 2) }}</div>
            <div class="stat-label">Monthly Contributions</div>
        </div>
    </div>
</div>

<div class="card" style="margin-top:20px">
    <h3 class="card-title">Offerings by Type</h3>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Total Amount (TZS)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($offeringsByType as $item)
                <tr>
                    <td>{{ $item->type }}</td>
                    <td><strong>{{ number_format($item->total, 2) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
