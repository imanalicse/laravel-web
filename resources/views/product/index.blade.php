@extends('layouts.app')

@section('content')

    <span class="cart_products_json d-none">{{$cart_products_json}}</span>
    <div class="container">
        <div class="product-grid">
            @if(!empty($products))
                @foreach($products as $product)
                    <div class="card" id="product-{{$product['id']}}">
                        <img src="https://cdn.shopify.com/s/files/1/2303/2711/files/2_e822dae0-14df-4cb8-b145-ea4dc0966b34.jpg?v=1617059123" class="card-img-top" alt="Fissure in Sandstone"/>
                        <div class="card-body p-0">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">${{ $product->price }}</p>
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
                @endforeach
            @else
                <div>No product available.</div>
            @endif
        </div>
        @if(!empty($products))
            {{$products->links()}}
        @endif
    </div>
@endsection
