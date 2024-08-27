@extends('layouts.app')

@section('content')
    <div class="flex-container">
        @forelse($products as $product)
            <div style="width: 400px">
                <h5>{{ $product->name }}</h5>
                <button class="btn btn-default btn-block"><span class="glyphicon glyphicon-shopping-cart"></span> Add to Cart</button>
            </div>
        @empty
            <div>No product available.</div>
        @endforelse
    </div>
@endsection
