@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Administration <span>/ System Settings</span></div>
<div class="page-header">
    <div>
        <h2>⚙️ System Settings</h2>
        <p>Configure church management system parameters</p>
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

<form action="{{ route('settings.update') }}" method="POST">
    @csrf
    <div class="grid-2">
        <div class="card">
            <h3 class="card-title" style="margin-bottom:16px">Church Information</h3>
            <div class="form-group-app">
                <label class="form-label-app">Church Name</label>
                <input type="text" name="church_name" class="form-control" value="{{ $settings['church_name'] }}">
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Address</label>
                <textarea name="church_address" class="form-control">{{ $settings['church_address'] }}</textarea>
            </div>
            <div class="grid-2">
                <div class="form-group-app">
                    <label class="form-label-app">Phone</label>
                    <input type="text" name="church_phone" class="form-control" value="{{ $settings['church_phone'] }}">
                </div>
                <div class="form-group-app">
                    <label class="form-label-app">Email</label>
                    <input type="email" name="church_email" class="form-control" value="{{ $settings['church_email'] }}">
                </div>
            </div>
        </div>

        <div class="card">
            <h3 class="card-title" style="margin-bottom:16px">System Preferences</h3>
            <div class="form-group-app">
                <label class="form-label-app">Currency</label>
                <select name="currency" class="form-control">
                    <option value="TZS" {{ $settings['currency'] == 'TZS' ? 'selected' : '' }}>Tanzanian Shilling (TZS)</option>
                    <option value="KES" {{ $settings['currency'] == 'KES' ? 'selected' : '' }}>Kenyan Shilling (KES)</option>
                    <option value="USD" {{ $settings['currency'] == 'USD' ? 'selected' : '' }}>US Dollar (USD)</option>
                </select>
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Fiscal Year Start Month</label>
                <select name="fiscal_year_start" class="form-control">
                    @for($m = 1; $m <= 12; $m++)
                    <option value="{{ sprintf('%02d', $m) }}" {{ $settings['fiscal_year_start'] == sprintf('%02d', $m) ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                    </option>
                    @endfor
                </select>
            </div>
            <div class="settings-section" style="border:none;padding:0">
                <div class="toggle-row">
                    <label>Email Notifications</label>
                    <label class="toggle"><input type="checkbox" name="email_notifications" value="1" {{ $settings['email_notifications'] == '1' ? 'checked' : '' }}><span class="toggle-slider"></span></label>
                </div>
                <div class="toggle-row">
                    <label>Automatic Backups</label>
                    <label class="toggle"><input type="checkbox" name="auto_backup" value="1" {{ $settings['auto_backup'] == '1' ? 'checked' : '' }}><span class="toggle-slider"></span></label>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-top:20px;display:flex;justify-content:flex-end">
        <button type="submit" class="btn btn-primary-solid">Save Changes</button>
    </div>
</form>
@endsection
