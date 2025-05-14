@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4 text-center">Checkout</h3>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control" required>{{ old('address') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success w-100">Place Order</button>
    </form>
</div>
@endsection