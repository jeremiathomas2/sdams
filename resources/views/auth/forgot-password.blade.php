@extends('layouts.auth')

@section('content')
<div class="auth-card">
    <div style="text-align:center;margin-bottom:24px">
        <div style="width:48px;height:48px;background:rgba(26,86,160,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        </div>
        <h2 style="font-size:1.3rem;font-weight:800;margin-bottom:6px">Reset Password</h2>
        <p style="color:var(--text-muted);font-size:0.88rem">Enter your email to receive a reset link</p>
    </div>

    @if(session('status'))
    <div class="alert alert-success" style="margin-bottom:16px">
        <div>{{ session('status') }}</div>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger" style="margin-bottom:16px">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group-app">
            <label class="form-label-app">Email Address</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus placeholder="you@example.com">
        </div>

        <button type="submit" class="btn btn-primary-solid" style="width:100%;margin-top:8px">Send Reset Link</button>

        <div style="text-align:center;margin-top:16px">
            <a href="{{ route('login') }}" style="color:var(--primary);font-weight:600;font-size:0.88rem">Back to Login</a>
        </div>
    </form>
</div>
@endsection
