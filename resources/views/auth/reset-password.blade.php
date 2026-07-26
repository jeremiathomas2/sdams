@extends('layouts.auth')

@section('content')
<div class="auth-card">
    <div style="text-align:center;margin-bottom:24px">
        <div style="width:48px;height:48px;background:rgba(26,86,160,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"/></svg>
        </div>
        <h2 style="font-size:1.3rem;font-weight:800;margin-bottom:6px">New Password</h2>
        <p style="color:var(--text-muted);font-size:0.88rem">Enter your new password below</p>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger" style="margin-bottom:16px">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group-app">
            <label class="form-label-app">Email Address</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $email) }}" required autofocus>
        </div>

        <div class="form-group-app">
            <label class="form-label-app">New Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group-app">
            <label class="form-label-app">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary-solid" style="width:100%;margin-top:8px">Reset Password</button>
    </form>
</div>
@endsection
