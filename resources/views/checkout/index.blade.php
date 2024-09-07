@extends('layouts.app')

@section('title', 'Checkout')

@section('header')
    @parent
@endsection

@section('content')
    <div class="container">
        <div class="row g-5">
            <div class="col-md-7 col-lg-8">

                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" id="address-tab" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Shipping & Billing Information
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">

                                <form class="" id="checkout-address-form">
                                    <div class="row g-3">

                                        <x-forms.input name="first_name" title="First Name" value="{{$user['name']}}" column="2" wrapper:class="abc" wrapper:id="bbb" required/>
                                        <x-forms.input name="last_name" title="Last Name" value="{{$user['name']}}" column="2"/>

                                        <div class="col-sm-6">
                                            <label for="email" class="form-label">Email <span class="text-muted"></span></label>
                                            <input type="email" name="email" value="{{ $user['email'] }}" class="form-control" id="email" placeholder="you@example.com" required>
                                            <div class="invalid-feedback">
                                                Please enter a valid email address for shipping updates.
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <label for="phone" class="form-label">Phone <span class="text-muted"></span></label>
                                            <input type="tel" name="phone" class="form-control phone" id="phone">
                                        </div>

                                        <div class="col-6">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" name="address_line_1" class="form-control @error('address_line_1') is-invalid @enderror" id="address" required>
                                            @error('address_line_1')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-6">
                                            <label for="address2" class="form-label">Address 2 <span class="text-muted">(Optional)</span></label>
                                            <input type="text" name="address_line_2" class="form-control" id="address2" placeholder="Apartment or suite">
                                        </div>

                                        <div class="col-md-5">
                                            <label for="country" class="form-label">Country</label>
                                            <select name="country" class="form-select" id="country" required>
                                                <option value="">Choose...</option>
                                                <option>United States</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="state" class="form-label">State</label>
                                            <select name="state" class="form-select" id="state">
                                                <option value="">Choose...</option>
                                                <option>California</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label for="postcode" class="form-label">Postcode</label>
                                            <input type="text" name="postcode" class="form-control" id="postcode">
                                        </div>
                                    </div>

                                    <hr class="my-4">

                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="same-address">
                                        <label class="form-check-label" for="same-address">Shipping address is the same as my billing address</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="save-info">
                                        <label class="form-check-label" for="save-info">Save this information for next time</label>
                                    </div>
                                    <button class="w-100 btn btn-primary btn-lg" type="submit">Continue</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" id="payment-tab" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Payment
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="my-3">
                                    <div class="form-check">
                                        <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked required>
                                        <label class="form-check-label" for="credit">Credit card</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="debit" name="paymentMethod" type="radio" class="form-check-input" required>
                                        <label class="form-check-label" for="debit">Debit card</label>
                                    </div>
                                    <div class="form-check">
                                        <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" required>
                                        <label class="form-check-label" for="paypal">PayPal</label>
                                    </div>
                                </div>

                                <div class="row gy-3">
                                    <div class="col-md-6">
                                        <label for="cc-name" class="form-label">Name on card</label>
                                        <input type="text" class="form-control" id="cc-name" placeholder="" required>
                                        <small class="text-muted">Full name as displayed on card</small>
                                        <div class="invalid-feedback">
                                            Name on card is required
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="cc-number" class="form-label">Credit card number</label>
                                        <input type="text" class="form-control" id="cc-number" placeholder="" required>
                                        <div class="invalid-feedback">
                                            Credit card number is required
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="cc-expiration" class="form-label">Expiration</label>
                                        <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
                                        <div class="invalid-feedback">
                                            Expiration date required
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="cc-cvv" class="form-label">CVV</label>
                                        <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                                        <div class="invalid-feedback">
                                            Security code required
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <button class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-lg-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Cart summary</span>
                    <span class="badge bg-primary rounded-pill">{{ count($cart['products']) }}</span>
                </h4>
                <ul class="list-group mb-3">
                    @forelse($cart['products'] as $product)
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">{{ $product['name'] }}</h6>
                                <small class="text-muted">{{ $product['quantity'] .' X '. $product['price'] }}</small>
                            </div>
                            <span class="text-muted">${{ $product['product_total'] }}</span>
                        </li>
                    @empty
                        <div>No product available.</div>
                    @endforelse

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total</span>
                        <strong>{{ $cart['amount']['currency'] .' '. $cart['amount']['order_total'] }}</strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
