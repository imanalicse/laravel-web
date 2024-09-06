{{--@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))--}}

@extends('layouts.app')

@section('content')
    <h2>{{ $exception->getMessage() }}</h2>
@endsection

