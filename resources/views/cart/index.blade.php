@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">Your Cart</h3>

    @if(session('success'))
    <div class="alert alert-success mb-4">
        {{ session('success') }}
    </div>
    @endif

    @if($cart && $cart->products->isNotEmpty())
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart->products as $product)
                <tr>
                    <td>{{ $product->name }}</td>

                    <td class="text-center align-middle">
                        <div class="d-inline-flex justify-content-center input-group input-group-sm" style="width: 120px;">
                            <form action="{{ route('cart.decrease', $product->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-outline-secondary" type="submit">−</button>
                            </form>
                            <span class="input-group-text bg-white">{{ $product->pivot->quantity }}</span>
                            <form action="{{ route('cart.increase', $product->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-outline-secondary" type="submit">+</button>
                            </form>
                        </div>
                    </td>

                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>${{ number_format($product->price * $product->pivot->quantity, 2) }}</td>
                    <td>
                        <form action="{{ route('cart.remove', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-link text-danger p-0" title="Remove">
                                <i class="bi bi-trash-fill fs-5"></i>
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between">
        <form action="{{ route('cart.clear') }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-warning">Clear Cart</button>
        </form>

        <div>
            <h4>Total: ${{ number_format($cart->products->sum(function($product) {
                return $product->price * $product->pivot->quantity;
            }), 2) }}</h4>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('checkout.form') }}" class="btn btn-lg btn-success w-100 rounded-3 shadow-lg" style="transition: transform 0.3s, background-color 0.3s;" onmouseover="this.style.transform='scale(1.05)'; this.style.backgroundColor='#28a745';" onmouseout="this.style.transform='scale(1)'; this.style.backgroundColor='#28a745';">
            <strong>Proceed to Checkout</strong>
        </a>
    </div>

    @else
    <p>Your cart is empty.</p>
    @endif
</div>
@endsection