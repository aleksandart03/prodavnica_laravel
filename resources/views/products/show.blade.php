@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <style>
        .add-to-cart-form button {
            transition: transform 0.3s ease;
        }

        .btn-animate {
            transform: scale(1.08);
        }
    </style>
    <div class="row">
        <div class="col-md-6">
            @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded shadow-sm">
            @else
            <img src="{{ asset('images/default.webp') }}" alt="No Image" class="img-fluid rounded shadow-sm">
            @endif
        </div>
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <p class="text-muted">{{ $product->description }}</p>
            <h4 class="text-success">${{ number_format($product->price, 2) }}</h4>

            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4 add-to-cart-form">
                @csrf
                <button type="submit" class="btn btn-outline-primary mt-3 w-50">
                    <i class="bi bi-cart-plus"></i> Add to Cart
                </button>
            </form>

            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary mt-3 w-50">
                <i class="bi bi-arrow-left"></i> Back to Store
            </a>

            <div id="ajax-message" class="mt-4"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/custom.js') }}"></script>
@endpush