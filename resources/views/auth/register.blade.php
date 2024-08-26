@extends('layouts.app')

@section('content')

    <div class="registration-form-wrapper">
        <h1 class="h3 mb-3 fw-normal">Sign up</h1>
        <form class="form-horizontal" method="POST" action="{{ route('registration.submit') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label">Name</label>
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">Email address</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">Password</label>
                <input id="password" type="password" class="form-control" name="password" autocomplete="off" required>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="password-confirm" class="col-md-4 control-label">Confirm password</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="off" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary mt-4">Register</button>
                <p class="small fw-bold mt-2 pt-1 mb-0">Have already an account? <a href="{{route('login')}}" class="link-danger">Sign In</a></p>
            </div>
        </form>
    </div>

@endsection
