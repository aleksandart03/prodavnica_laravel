@extends('layouts.breeze.app')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
        {{ __('Admin Categories') }}
    </h2>

    <div class="btn-group">
        <a href="{{ route('admin.products') }}" class="btn btn-outline-primary me-3">Products</a>
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
                    <h1 class="mb-0 text-dark">Category List</h1>
                    <div class="btn-group">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Add Category</a>

                        {{-- Export --}}
                        <a href="{{ route('categories.export') }}" class="btn btn-outline-success ms-2">Export</a>

                        {{-- Import Form --}}
                        <form action="{{ route('categories.import') }}" method="POST" enctype="multipart/form-data" class="d-inline-block ms-2">
                            @csrf
                            <div class="input-group">
                                <input type="file" name="file" class="form-control" required>
                                <button type="submit" class="btn btn-outline-primary">Import</button>
                            </div>
                        </form>
                    </div>
                </div>


                <hr class="my-5" />

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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                            <tr>
                                <td class="align-middle">{{ $category->id }}</td>
                                <td class="align-middle">{{ $category->name }}</td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-outline-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.categories.delete', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="3">No categories found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $categories->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection