<div class="row">

    <style>
        .product-link {
            display: block;
            border: none !important;
            padding: 0;
            margin: 0;
        }

        .product-img {
            display: block;
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 0;
            border: none;
            transition: transform 0.7s ease;
        }


        .product-link:hover .product-img {
            transform: scale(1.05);
            cursor: pointer;
        }

        .add-to-cart-form button {
            transition: transform 0.3s ease;
        }

        .btn-animate {
            transform: scale(1.08);
        }
    </style>

    @foreach($products as $product)
    <div class="col-md-3 mb-4">
        <div class="card h-100 shadow-sm border-0 product-card">
            <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-secondary border-0 product-link p-0">
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top product-img" alt="Product Image" style="object-fit: cover;">
                @else
                <img src="{{ asset('images/default.webp') }}" class="card-img-top product-img" alt="Default Image" style="object-fit: cover;">
                @endif
            </a>

            <div class="card-body d-flex flex-column justify-content-between">
                <h5 class="card-title text-center">{{ $product->name }}</h5>
                <p class="card-text small text-muted">{{ Str::limit($product->description, 80) }}</p>
                <p class="card-text fw-bold text-center mb-3">${{ number_format($product->price, 2) }}</p>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto add-to-cart-form">
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