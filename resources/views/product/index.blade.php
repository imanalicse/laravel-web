@extends('layouts.app')

@section('content')

    <span class="cart_products_json d-none 2"><?php echo $cart_products_json; ?></span>
    <div class="flex-container product-grid">
        @forelse($products as $product)
            <div class="card" id="product-<?php echo $product['id']; ?>">
                <img src="https://mdbcdn.b-cdn.net/img/new/standard/nature/184.webp" class="card-img-top" alt="Fissure in Sandstone"/>
                <div class="card-body p-0">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                </div>
                <div class="card-footer text-center2 p-0">
                    <div class="add-to-cart-box" data-product_id="{{$product['id']}}">
                        <button class="btn btn-secondary cart-btn-width add-to-cart-btn js-btn-add-cart">Add to cart</button>
                        <div class="cart-added-box btn-group cart-btn-width d-none">
                            <button class="btn btn-secondary cart-decrease-action">-</button>
                            <button class="btn btn-secondary added-in-cart"><span class="quantity">1</span> in cart</button>
                            <button class="btn btn-secondary cart-increase-action">+</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div>No product available.</div>
        @endforelse

            {{$products->links()}}
    </div>
@endsection
