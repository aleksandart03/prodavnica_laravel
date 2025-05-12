@extends('layouts.breeze.guest')

@section('content')
<!-- Session Status -->
@if (session('status'))
<div class="alert alert-success mb-4">
    {{ session('status') }}
</div>
@endif

<!-- Centrirana forma bez crne pozadine -->
<div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <div class="w-100 w-md-50 w-lg-40 bg-white p-4 p-md-5 shadow-lg rounded-3">
        <h2 class="text-center mb-4 text-dark">Log in</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="current-password">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="form-check mb-4">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                <label for="remember_me" class="form-check-label text-muted">
                    {{ __('Remember me') }}
                </label>
            </div>

            <!-- Action buttons -->
            <div class="d-flex justify-content-between align-items-center">
                @if (Route::has('password.request'))
                <a class="text-decoration-none text-muted hover:text-primary"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif

                <button type="submit" class="btn btn-primary px-4 py-2">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>

        <!-- Register Link -->
        <div class="mt-4 text-center">
            <p class="mb-0 text-muted">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-decoration-none text-primary">Register here</a>
            </p>
        </div>
    </div>
</div>
@endsection