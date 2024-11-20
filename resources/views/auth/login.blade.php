@extends('layouts.app')

@section('content')

    <div class="login-form-wrapper">
        <h1 class="h3 mb-3 fw-normal">Sign in</h1>
        <form class="form-horizontal" method="POST" action="{{ route('login.submit') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" autocomplete="off" autofocus>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" autocomplete="off">
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
              <input type="checkbox" name="remember_me" class="custom-control-input" id="remember_me">
              <label class="custom-control-label" for="remember_me">Remember me </label>
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-default login btn-primary mt-4">LOGIN</button>
                <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="{{route('registration')}}" class="link-danger">Sign up</a></p>
            </div>
        </form>
    </div>
@endsection
