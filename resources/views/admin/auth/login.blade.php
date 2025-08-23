@extends('admin.layouts.auth')

@section('title', 'Login')

@section('content')
<h4>Hello! let's get started</h4>
<h6 class="fw-light">Sign in to continue.</h6>

<form method="POST" action="{{ route('admin.login') }}" class="pt-3">
    @csrf

    <div class="form-group">
        <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" required>
    </div>
    <div class="form-group">
        <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
    </div>

    <div class="mt-3 d-grid gap-2">
        <button class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn" type="submit">
            SIGN IN
        </button>
    </div>

    <div class="my-2 d-flex justify-content-between align-items-center">
        <div class="form-check">
            <label class="form-check-label text-muted">
                <input type="checkbox" name="remember" class="form-check-input"> Keep me signed in
            </label>
        </div>
        <a href="{{ route('admin.password.request') }}" class="auth-link text-black">Forgot password?</a>
    </div>

    <div class="text-center mt-4 fw-light">
        Don’t have an account? <a href="{{ route('admin.register') }}" class="text-primary">Create</a>
    </div>
</form>
@endsection
