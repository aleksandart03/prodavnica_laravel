@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">Checkout Confirmed</h3>

    @if(session('order'))
    <div class="alert alert-success mb-4">
        <h4 class="fw-bold">Thank you for your order!</h4>
        <p>Your order has been successfully placed. Below are your order details:</p>

        <div class="mb-3">
            <h5>Order Details</h5>
            <ul class="list-group">
                <li class="list-group-item"><strong>Name:</strong> {{ session('order')->name }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ session('order')->email }}</li>
                <li class="list-group-item"><strong>Address:</strong> {{ session('order')->address }}</li>
                <li class="list-group-item"><strong>Total Price:</strong> ${{ number_format(session('order')->total_price, 2) }}</li>
            </ul>
        </div>

        <div class="mt-4">
            <h5>Order Items:</h5>
            <ul class="list-group">
                @foreach(session('order')->orderProducts as $product)
                <li class="list-group-item">
                    {{ $product->product->name }} ({{ $product->quantity }}) - ${{ number_format($product->price * $product->quantity, 2) }}
                </li>
                @endforeach
            </ul>
        </div>

        <div class="mt-5 text-center">
            <a href="{{ route('home') }}" class="btn btn-primary w-50">
                <i class="bi bi-arrow-left-circle"></i> Back to Store
            </a>
        </div>
    </div>
    @endif
</div>
@endsection