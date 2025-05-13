@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4 text-center">All Products</h3>

    @if(session('success'))
    <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach($products as $product)
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm border-0 product-card">
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                @else
                <img src="{{ asset('images/default.webp') }}" class="card-img-top" alt="No Image" style="height: 200px; object-fit: cover;">
                @endif

                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title text-center">{{ $product->name }}</h5>
                    <p class="card-text small text-muted">{{ Str::limit($product->description, 80) }}</p>
                    <p class="card-text fw-bold text-center mb-3">${{ number_format($product->price, 2) }}</p>

                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection