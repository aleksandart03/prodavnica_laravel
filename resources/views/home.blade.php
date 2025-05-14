@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="display-4">Welcome to Our Store</h1>
            <p class="lead">Discover the latest products and offers.</p>
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

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="row">
                @foreach($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm border-0 product-card">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        @else
                        <img src="{{ asset('images/default.webp') }}" class="card-img-top" alt="No Image" style="height: 300px; width:100%; object-fit: cover;">
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

                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-secondary w-100 mt-2">
                                <i class="bi bi-info-circle"></i> Show Details
                            </a>
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