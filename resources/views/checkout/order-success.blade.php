@extends('layouts.app')

@section('title', 'Order success')

@section('header')
    @parent
@endsection

@section('content')
    <div class="container">
        <p>Thank you for order</p>
        <p>Order reference code: {{$reference_code}}</p>
    </div>
@endsection
