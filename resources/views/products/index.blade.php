@extends('layouts.app')

@section('content')
<div class="container mt-4">

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
            transition: height 0.8s ease;
            pointer-events: none;
        }
    </style>

    <div class="mb-4 position-relative" style="max-width: 500px; margin: 0 auto;">
        <input type="text" id="product-search" class="form-control ps-5" placeholder="Search products...">
        <i class="bi bi-search position-absolute"
            style="top: 50%; left: 15px; transform: translateY(-50%); pointer-events: none; color: #6c757d; font-size: 1rem;">
        </i>
        <div id="search-results" class="list-group"></div>
    </div>




    <form id="filter-form" method="GET" action="{{ route('products.index') }}" class="mb-4">

        <div class="row justify-content-center g-3">

            <div class="col-md-3">
                <label for="price_min" class="form-label">Price From</label>
                <input type="number" name="price_min" class="form-control" value="{{ request('price_min') }}">
            </div>

            <div class="col-md-3">
                <label for="price_max" class="form-label">Price To</label>
                <input type="number" name="price_max" class="form-control" value="{{ request('price_max') }}">
            </div>

            <div class="col-md-3">
                <label for="category" class="form-label">Category</label>
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="sort" class="form-label">Sort by</label>
                <select name="sort" class="form-select">
                    <option value="">None</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name A - Z</option>
                    <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Name Z - A</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price Low - High</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price High - Low</option>
                </select>
            </div>

        </div>

        <div class="row mt-3 mb-5">
            <div class="col-12 d-flex justify-content-center gap-2">
                <button type="submit" class="btn btn-primary px-4">Filter</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary px-4">Reset</a>
            </div>
        </div>
    </form>



    <h3 class="mb-4 text-center">All Products</h3>

    <div id="ajax-message" class="mt-4"></div>

    <div id="product-list">
        @include('products.partials.product_list')
    </div>

    <div id="pagination-container" class="col-12 d-flex justify-content-center">
        @include('products.partials.pagination', ['paginator' => $products])
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