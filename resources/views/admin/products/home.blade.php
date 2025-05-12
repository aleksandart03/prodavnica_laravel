@extends('layouts.breeze.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
        {{ __('Admin Product') }}
    </h2>

    <div class="btn-group">
        <a href="{{ route('admin.categories') }}" class="btn btn-outline-primary me-3">Categories</a>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Back</a>
    </div>
</div>
@endsection

@section('content')
<div class="py-12">
    <div class="container-xl">
        <div class="card shadow-lg border-0 rounded-4 mt-4">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
                    <h1 class="mb-0 text-dark">Product List</h1>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-lg btn-primary">Add Product</a>
                </div>

                <hr class="my-4" />

                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="table-responsive mt-4">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? 'No Category' }}</td>
                                <td>{{ number_format($product->price, 2) }}</td>
                                <td>{{ Str::limit($product->description, 50) }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-outline-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No products found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection