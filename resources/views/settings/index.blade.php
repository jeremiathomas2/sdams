@extends('layouts.app')

@section('content')
<div class="breadcrumb">Home / Administration <span>/ System Settings</span></div>
<div class="page-header">
    <div>
        <h2>⚙️ System Settings</h2>
        <p>Configure church management system parameters</p>
    </div>
</div>

<div class="grid-2">
    <div class="card">
        <h3 class="card-title" style="margin-bottom:16px">Church Information</h3>
        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            <div class="form-group-app">
                <label class="form-label-app">Church Name</label>
                <input type="text" name="church_name" class="form-control" value="SDA Church CMS">
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Conference/Mission</label>
                <input type="text" name="conference" class="form-control" value="East-Central Africa Division">
            </div>
            <div class="form-group-app">
                <label class="form-label-app">Address</label>
                <textarea name="address" class="form-control">Dar es Salaam, Tanzania</textarea>
            </div>
            <button type="submit" class="btn btn-primary-solid">Save Changes</button>
        </form>
    </div>

    <div class="card">
        <h3 class="card-title" style="margin-bottom:16px">System Preferences</h3>
        <div class="settings-section" style="border:none;padding:0">
            <div class="toggle-row">
                <label>Email Notifications</label>
                <label class="toggle"><input type="checkbox" checked><span class="toggle-slider"></span></label>
            </div>
            <div class="toggle-row">
                <label>Audit Logging</label>
                <label class="toggle"><input type="checkbox" checked><span class="toggle-slider"></span></label>
            </div>
            <div class="toggle-row">
                <label>Automatic Backups</label>
                <label class="toggle"><input type="checkbox"><span class="toggle-slider"></span></label>
            </div>
            <div style="margin-top:16px">
                <label class="form-label-app">Currency</label>
                <select class="form-control">
                    <option value="TZS">Tanzanian Shilling (TZS)</option>
                    <option value="KES">Kenyan Shilling (KES)</option>
                    <option value="USD">US Dollar (USD)</option>
                </select>
            </div>
        </div>
    </div>
</div>
@endsection
