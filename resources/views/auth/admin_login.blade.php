@extends('layouts.auth')

@section('content')

<div class="login-page">
        <div class="branding-part text-center">
            <img src="{{asset('src/admin/img/new-logo.png')}}" alt="" style="max-width: 337px">
        </div>
        <div class="login-wrapper">
            <div class="login-form">
                    <form class="form-horizontal" method="POST" action="{{ route('login.admin.submit') }}">
                            {{ csrf_field() }}
                        <div class="content-box">
                            <div class="card-title"><h1>Admin Log in</h1></div>
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
                                <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="{{route('registration')}}" class="link-danger">Register</a></p>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection
