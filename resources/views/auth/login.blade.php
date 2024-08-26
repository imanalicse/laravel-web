@extends('layouts.app')

@section('content')

    <div class="login-form-wrapper">
        <h1 class="h3 mb-3 fw-normal">Sign in</h1>
        <form class="form-horizontal" method="POST" action="{{ route('login.submit') }}">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="" autocomplete="off" required autofocus>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password">Password</label>
                <input id="password" type="password" class="form-control" name="password" placeholder="" autocomplete="off" required>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
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
