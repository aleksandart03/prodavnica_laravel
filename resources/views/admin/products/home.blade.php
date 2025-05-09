<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Product') }}
        </h2>

        <div class="mt-4">
            <a href="{{ route('admin.categories') }}" class="btn btn-primary mr-2">Categories</a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="d-flex align-items-center justify-content-between">
                        <h1 class="mb-0">Product List</h1>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a>
                    </div>
                    <hr />
                    @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>
                    @endif
                    <table class="table table-hover">
                        <thead class="table-primary">
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
                                <td class="align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">{{ $product->name }}</td>
                                <td class="align-middle">{{ $product->category->name ?? 'No Category' }}</td>
                                <td class="align-middle">{{ number_format($product->price, 2) }}</td>
                                <td class="align-middle">{{ Str::limit($product->description, 50) }}</td>
                                <td class="align-middle">
                                    <div class="btn-group" role="group" aria-label="Actions">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-secondary">Edit</a>
                                        <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="6">No products found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>