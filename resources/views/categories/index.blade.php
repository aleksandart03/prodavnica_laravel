@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>All Categories</h3>
    <ul class="list-group">
        @foreach($categories as $category)
        <li class="list-group-item">{{ $category->name }}</li>
        @endforeach
    </ul>
</div>
@endsection