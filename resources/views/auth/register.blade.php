@extends('layouts.auth')

@section('content')
    <div class="auth-page active" id="page-register">
      <div class="auth-title">Create Account</div>
      <div class="auth-sub">Register a new administrator account</div>
      
      @if ($errors->any())
      <div class="alert alert-danger">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
      @endif

      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
          <label class="form-label">Full Name</label>
          <input class="form-input" type="text" name="name" placeholder="John Doe" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
          <label class="form-label">Email Address</label>
          <div class="input-icon-wrap">
            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            <input class="form-input" type="email" name="email" placeholder="john@church.org" value="{{ old('email') }}" required>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Role</label>
          <select class="form-input" name="role" required>
            <option value="Administrator">Administrator</option>
            <option value="Finance Clerk">Finance Clerk</option>
            <option value="Membership Clerk">Membership Clerk</option>
            <option value="Pastor">Pastor</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Password</label>
          <div class="input-icon-wrap">
            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            <input class="form-input" type="password" name="password" placeholder="Create a strong password" id="reg-pass" oninput="checkStrength(this.value)" required>
            <span class="input-eye" onclick="togglePwd('reg-pass',this)"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></span>
          </div>
          <div class="strength-bar"><div class="strength-seg" id="s1"></div><div class="strength-seg" id="s2"></div><div class="strength-seg" id="s3"></div><div class="strength-seg" id="s4"></div></div>
          <div style="font-size:0.77rem;color:var(--text-muted);margin-top:4px;" id="strength-label">Enter a password</div>
        </div>
        <div class="form-group">
          <label class="form-label">Confirm Password</label>
          <div class="input-icon-wrap">
            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            <input class="form-input" type="password" name="password_confirmation" placeholder="Repeat password" required>
          </div>
        </div>
        <button type="submit" class="btn-primary">Create Account</button>
      </form>
      <div class="auth-link"><a href="{{ route('login') }}">← Back to Sign In</a></div>
    </div>
@endsection
