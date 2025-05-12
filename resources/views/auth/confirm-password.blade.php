<x-guest-layout>
    <div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
        <div class="w-100 w-md-50 w-lg-40 bg-white p-4 p-md-5 shadow-lg rounded-3">
            <h2 class="text-center mb-4 text-dark">Confirm Your Password</h2>

            <div class="mb-4 text-sm text-gray-600">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="invalid-feedback" />
                </div>

                <!-- Confirm Button -->
                <div class="d-flex justify-content-end">
                    <x-primary-button class="btn btn-primary px-4 py-2">
                        {{ __('Confirm') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>