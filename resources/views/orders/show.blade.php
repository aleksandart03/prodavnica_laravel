@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Detalji narudžbine #{{ $order->id }}</h3>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <p><strong>Ime kupca:</strong> {{ $order->name }}</p>
                <p><strong>Email:</strong> {{ $order->email }}</p>
                <p><strong>Adresa:</strong> {{ $order->address }}</p>
                <p><strong>Ukupno:</strong> <span class="badge bg-success">{{ number_format($order->total_price, 2) }} RSD</span></p>
            </div>

            <hr>

            <h5>Proizvodi u narudžbini:</h5>
            <table class="table table-bordered table-striped mt-3 align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 120px;">Slika</th>
                        <th>Naziv</th>
                        <th>Količina</th>
                        <th>Cena po komadu</th>
                        <th>Ukupno</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->products as $product)
                    <tr>
                        <td>
                            @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded shadow-sm" style="max-height: 80px;">
                            @else
                            <img src="{{ asset('images/default.webp') }}" alt="No Image" class="img-fluid rounded shadow-sm" style="max-height: 80px;">
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>{{ number_format($product->price, 2) }} $</td>
                        <td>{{ number_format($product->pivot->quantity * $product->price, 2) }} RSD</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection