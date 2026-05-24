@extends('layouts.auth')

@section('content')
    <div class="auth-page active" id="page-login">
      <div class="auth-title">Welcome Back</div>
      <div class="auth-sub">Sign in to your account to continue</div>
      
      @if ($errors->any())
      <div class="alert alert-danger">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        @foreach ($errors->all() as $error)
            {{ $error }}
        @endforeach
      </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label class="form-label">Email Address</label>
            <div class="input-icon-wrap">
            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <input class="form-input" type="email" name="email" placeholder="admin@church.org" value="{{ old('email') }}" required autofocus>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label">Password</label>
            <div class="input-icon-wrap">
            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            <input class="form-input" type="password" name="password" id="login-pass" placeholder="••••••••" required>
            <span class="input-eye" onclick="togglePwd('login-pass',this)">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </span>
            </div>
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
            <label style="display:flex;align-items:center;gap:7px;font-size:0.85rem;color:var(--text-muted);cursor:pointer;">
            <input type="checkbox" name="remember" style="accent-color:var(--primary)"> Remember me
            </label>
            <a style="font-size:0.85rem;color:var(--primary);font-weight:600;cursor:pointer;" href="{{ route('password.request') }}">Forgot password?</a>
        </div>
        <button type="submit" class="btn-primary">Sign In</button>
      </form>

      <div class="auth-divider"><span>New to the system?</span></div>
      <div class="auth-link"><a href="{{ route('register') }}">Create an account →</a></div>
    </div>
@endsection
