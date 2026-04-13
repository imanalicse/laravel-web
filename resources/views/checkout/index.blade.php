@extends('layouts.app')

@section('title', 'Checkout')

@section('header')
    @parent
@endsection

@section('content')
    @php
        use App\Enum\PaymentMethod;
    @endphp
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
                                            <label for="address_line_1" class="form-label">Address line 1</label>
                                            <input type="text" name="address_line_1" class="form-control @error('address_line_1') is-invalid @enderror" id="address_line_1">
                                            @error('address_line_1')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-6">
                                            <label for="address_line_2" class="form-label">Address line 2 <span class="text-muted">(Optional)</span></label>
                                            <input type="text" name="address_line_2" class="form-control" id="address_line_2" placeholder="Apartment or suite">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="country" class="form-label">Country</label>
                                            <select name="country" class="form-select" id="country">
                                                <option value="">Choose...</option>
                                                <option>United States</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="state" class="form-label">State</label>
                                            <select name="state" class="form-select" id="state">
                                                <option value="">Choose...</option>
                                                <option>California</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" name="city" class="form-control" id="city">
                                        </div>

                                        <div class="col-md-6">
                                            <label for="postcode" class="form-label">Postcode</label>
                                            <input type="number" name="postcode" maxlength="4" class="form-control" id="postcode">
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

                                <div class="payment-method-box">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="input radio my-2">
                                            <span class="custom-radio">
                                                <input type="radio" id="<?php echo PaymentMethod::STRIPE; ?>" name="payment_method" value="<?php echo PaymentMethod::STRIPE; ?>">
                                                <label for="<?php echo PaymentMethod::STRIPE; ?>"><?php echo PaymentMethod::STRIPE; ?></label>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-end my-2">
                                            <div class="payment-method-img">
                                                <img src="{{Vite::image('visa-card-group.png')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-2">

                                        {{--Stripe block--}}
                                        <div class="js_stripe_payment_form_wrapper d-none">
                                            @push('scripts_top')
                                                <script src="https://js.stripe.com/v3/"></script>
                                            @endpush
                                            @php
                                                $stripe_public_key = env('STRIPE_PUBLIC_KEY');
                                            @endphp
                                            <input type="hidden" id="stripe_public_key" value="<?php echo $stripe_public_key; ?>">
                                            <div id="stripe-ui-container" class="stripe-card-wrap">
                                                <form id="payment-form">
                                                    {{--                                                <label for="card-element">Stripe Card</label>--}}
                                                    <div id="card-element">
                                                        <!-- Elements will create input elements here -->
                                                    </div>

                                                    <!-- We'll put the error messages in this element -->
                                                    <div id="card-errors" role="alert"></div>

                                                    <button type="submit" class="d-none" id="stripe-pay-now-btn">Pay</button>
                                                </form>
                                            </div>
                                        </div>
                                        {{--Stripe block end--}}
                                    </div>
                                </div>

                                <div class="payment-method-box">
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="input radio my-2">
                                            <span class="custom-radio">
                                                <input type="radio" id="<?php echo PaymentMethod::PAY_PAL; ?>" name="payment_method" value="<?php echo PaymentMethod::PAY_PAL; ?>">
                                                <label for="<?php echo PaymentMethod::PAY_PAL; ?>"><?php echo PaymentMethod::PAY_PAL; ?></label>
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-end my-2">
                                            <div class="payment-method-img">
                                                <img src="{{Vite::image('paypal-logo.png')}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div class="button-container">
                                    <button class="w-100 btn btn-primary btn-lg d-none disabled js_pay_now_btn_common" id="stripe-pay-now-additional-btn">Confirm & Pay</button>
                                    <button class="w-100 btn btn-primary btn-lg d-none js_pay_now_btn_common" id="js_offline_pay_btn">Confirm & Pay</button>
                                    @include('checkout.paypal_button');
                                </div>
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

    @push('scripts_top')
        <script src="https://api.quickstream.support.qvalent.com/rest/v1/quickstream-api-1.0.min.js"></script>
    @endpush

    @prepend('scripts')

    @endprepend

@endsection
