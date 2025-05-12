@extends('layouts.breeze.app')

@section('header')
<h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight text-left">
    {{ __('Dashboard Admin') }}
</h2>
@endsection

@section('content')
<div class="py-12 mt-5">
    <div class="container-xl">
        <div class="row justify-content-center">
            <!-- Products Card -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-lg h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title text-lg font-semibold">{{ __('Products') }}</h5>
                        <p class="text-muted">{{ __('Manage your products here') }}</p>
                        <a href="products" class="btn btn-primary mt-3">{{ __('Go to Products') }}</a>
                    </div>
                </div>
            </div>

            <!-- Categories Card -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-lg h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title text-lg font-semibold">{{ __('Categories') }}</h5>
                        <p class="text-muted">{{ __('Manage your categories here') }}</p>
                        <a href="categories" class="btn btn-primary mt-3">{{ __('Go to Categories') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection