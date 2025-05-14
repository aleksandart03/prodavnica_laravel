@extends('layouts.app')

@section('content')
<div class="container mt-5">
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

            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-cart-plus"></i> Add to Cart
                </button>
            </form>

            <a href="{{ route('home') }}" class="btn btn-outline-secondary mt-3">
                <i class="bi bi-arrow-left"></i> Back to Store
            </a>
        </div>
    </div>
</div>
@endsection