@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">Your Cart</h3>

    <div id="ajax-message"></div>

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

                <!-- ========== Style za input da se ne vide strelice ========== -->

                <style>
                    input[type=number]::-webkit-inner-spin-button,
                    input[type=number]::-webkit-outer-spin-button {
                        -webkit-appearance: none;
                        margin: 0;
                    }
                </style>

                @foreach($cart->products as $product)
                <tr id="product-row-{{ $product->id }}">
                    <td class="d-flex align-items-center gap-3">
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-secondary border-0 p-0" style="width: 60px; height: 60px; flex-shrink: 0;">
                            @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                            @else
                            <img src="{{ asset('images/default.webp') }}" alt="Default Image" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                            @endif
                        </a>
                        <span>{{ $product->name }}</span>
                    </td>

                    <td class="text-center align-middle">
                        <div class="d-inline-flex justify-content-center input-group input-group-sm" style="width: 120px;">
                            <form action="{{ route('cart.decrease', $product->id) }}" method="POST" class="ajax-cart-action" data-product-id="{{ $product->id }}">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-outline-secondary" type="submit">−</button>
                            </form>
                            <input type="number" min="1" class="form-control text-center quantity-input" style="max-width: 60px;" data-product-id="{{ $product->id }}" value="{{ $product->pivot->quantity }}">
                            <form action="{{ route('cart.increase', $product->id) }}" method="POST" class="ajax-cart-action" data-product-id="{{ $product->id }}">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-outline-secondary" type="submit">+</button>
                            </form>
                        </div>
                    </td>

                    <td>${{ number_format($product->price, 2) }}</td>
                    <td id="item-total-{{ $product->id }}">${{ number_format($product->price * $product->pivot->quantity, 2) }}</td>

                    <td>
                        <form action="{{ route('cart.remove', $product->id) }}" method="POST" class="ajax-cart-action d-inline" data-product-id="{{ $product->id }}">
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
        <form action="{{ route('cart.clear') }}" method="POST" class="ajax-cart-action">
            @csrf
            @method('DELETE')
            <button class="btn btn-warning">Clear Cart</button>
        </form>
        <div>
            <h4>Total: $<span id="cart-total">
                    {{ number_format($cart->products->sum(fn($product) => $product->price * $product->pivot->quantity), 2) }}
                </span></h4>

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


@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/custom.js') }}"></script>
@endpush