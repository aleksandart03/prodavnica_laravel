<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Centrirana forma bez crne pozadine -->
    <div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
        <div class="w-100 w-md-50 w-lg-40 bg-white p-4 p-md-5 shadow-lg rounded-3">
            <h2 class="text-center mb-4 text-dark">Log in</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="invalid-feedback" />
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="invalid-feedback" />
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-4">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label for="remember_me" class="form-check-label text-muted">
                        {{ __('Remember me') }}
                    </label>
                </div>

                <!-- Action buttons: login & forgot password -->
                <div class="d-flex justify-content-between align-items-center">
                    @if (Route::has('password.request'))
                    <a class="text-decoration-none text-muted hover:text-primary" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                    @endif

                    <x-primary-button class="btn btn-primary px-4 py-2">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>

            <!-- Register Link -->
            <div class="mt-4 text-center">
                <p class="mb-0 text-muted">Don't have an account? <a href="{{ route('register') }}" class="text-decoration-none text-primary">Register here</a></p>
            </div>
        </div>
    </div>
</x-guest-layout>