@extends('layouts.app')

@section('content')
    <div class="flex-container product-grid">
        @forelse($products as $product)
            <div class="card">
                <img src="https://mdbcdn.b-cdn.net/img/new/standard/nature/184.webp" class="card-img-top" alt="Fissure in Sandstone"/>
                <div class="card-body p-0">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                </div>
                <div class="card-footer text-center2 p-0"><a href="#" class="btn btn-secondary js-btn-add-cart" data-mdb-ripple-init>Add to cart</a></div>
            </div>
        @empty
            <div>No product available.</div>
        @endforelse

            {{$products->links()}}
    </div>
@endsection
