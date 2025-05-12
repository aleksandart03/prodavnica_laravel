@extends('layouts.breeze.app')

@section('content')
<div class="py-12 mt-5">
    <div class="container-xl">
        <div class="row justify-content-center g-4">
            <!-- Card: Welcome -->
            <div class="col-md-3 d-flex">
                <div class="card shadow-lg border-light rounded-3 mb-4 w-100">
                    <div class="card-body text-center">
                        <i class="bi bi-person-check h1 text-primary mb-3"></i>
                        <h5 class="card-title mb-3">{{ __('Welcome') }}</h5>
                        <p class="card-text">{{ __("You're logged in!") }}</p>
                    </div>
                </div>
            </div>

            <!-- Card: Quick Access -->
            <div class="col-md-3 d-flex">
                <div class="card shadow-lg border-light rounded-3 mb-4 w-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ __('Quick Access') }}</h5>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('profile.edit') }}" class="btn btn-link">{{ __('Edit Profile') }}</a></li>
                            <li><a href="{{ route('logout') }}" class="btn btn-link">{{ __('Log Out') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection