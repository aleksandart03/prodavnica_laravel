@extends('layouts.breeze.app')

@section('header')
<h2 class="font-semibold text-3xl text-gray-800 leading-tight">
    {{ __('Create Category') }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body">
                <form action="{{ route('admin.categories.save') }}" method="POST">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-gray-700 font-semibold mb-2">Category Name</label>
                        <input type="text" name="name" class="form-control w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('name') }}" required>
                        @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end mt-6">
                        <a href="{{ route('admin.categories') }}" class="btn btn-secondary btn-lg">Back</a>
                        <button type="submit" class="btn btn-lg btn-primary">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection