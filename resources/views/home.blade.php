@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="display-4">Welcome to Our Store</h1>
            <p class="lead">Discover the latest products and offers.</p>

            <style>
                #search-results {
                    position: absolute;
                    top: 100%;
                    left: 0;
                    right: 0;
                    background: #fff;
                    border: 1px solid #ddd;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    z-index: 1050;
                    border-radius: 0 0 4px 4px;
                    overflow: hidden;
                    height: 0;
                    transition: height 0.5s ease;
                    pointer-events: none;
                    padding: 0;
                }

                #search-results.open {
                    pointer-events: auto;
                }
            </style>

            <div class="mb-4 position-relative" style="max-width: 500px; margin: 0 auto;">
                <input type="text" id="product-search" class="form-control ps-5" placeholder="Search products...">
                <i class="bi bi-search position-absolute"
                    style="top: 50%; left: 15px; transform: translateY(-50%); pointer-events: none; color: #6c757d; font-size: 1rem;">
                </i>
                <div id="search-results" class="list-group"></div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <style>
            .equal-height-banner {
                height: 600px;
                object-fit: cover;
                width: 100%;
                border-radius: 10px;
                animation: fadeIn 1s ease-in-out forwards;
            }

            .promo-banner img {
                opacity: 0;
                transition: transform 0.5s ease, box-shadow 0.5s ease;
                border-radius: 0.75rem;

            }

            .promo-banner:hover img {
                transform: scale(1.05);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            }


            .fade-in-left {
                animation: fadeInLeft 0.8s ease forwards;
            }


            .fade-in-up {
                animation: fadeInUp 0.8s ease forwards;
            }


            .fade-in-right {
                animation: fadeInRight 0.8s ease forwards;
            }


            @keyframes fadeInLeft {
                0% {
                    opacity: 0;
                    transform: translateX(-50px);
                }

                100% {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes fadeInUp {
                0% {
                    opacity: 0;
                    transform: translateY(50px);
                }

                100% {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes fadeInRight {
                0% {
                    opacity: 0;
                    transform: translateX(50px);
                }

                100% {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            .product-link {
                overflow: hidden;
                border: none !important;
                padding: 0 !important;
            }

            .product-img {
                transition: transform 0.7s ease;
                display: block;
                width: 100%;
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

        <div class="row">
            <div class="col-md-4">
                <a href="#" class="promo-banner">
                    <img src="{{ asset('images/iphne15.jpg') }}" class="img-fluid equal-height-banner fade-in-left" alt="Banner 1" style="animation-delay: 0.1s;">
                </a>
            </div>

            <div class="col-md-4">
                <a href="#" class="promo-banner">
                    <img src="{{ asset('images/iphone16.jpg') }}" class="img-fluid equal-height-banner fade-in-up" alt="Banner 2" style="animation-delay: 0.3s;">
                </a>
            </div>

            <div class="col-md-4">
                <a href="#" class="promo-banner">
                    <img src="{{ asset('images/airpods.jpg') }}" class="img-fluid equal-height-banner fade-in-right" alt="Banner 3" style="animation-delay: 0.5s;">
                </a>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <h3 class="mb-4">New Products</h3>

        <div id="ajax-message" class="mt-4"></div>

        <div class="row">
            <div class="row">
                @foreach($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm border-0 product-card">
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-secondary border-0 product-link p-0">
                            @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top product-img" alt="Product Image" style="height: 200px; object-fit: cover;">
                            @else
                            <img src="{{ asset('images/default.webp') }}" class="card-img-top product-img" alt="Default Image" style="height: 200px; object-fit: cover;">
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

            <div class="text-center mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-lg">
                    Go to Products
                </a>
            </div>
        </div>
    </div>

    @endsection

    @push('scripts')

    <script>
        window.routes = {
            productSearch: "{{ route('products.search') }}"
        };
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/pagination.js') }}"></script>
    @endpush