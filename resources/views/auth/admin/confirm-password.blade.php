@extends('layouts.auth')

@section('content')

<div class="login-page">
    <div class="branding-part text-center">
        <img src="{{asset('src/admin/img/new-logo.png')}}" alt="" style="max-width: 337px">
    </div>
    <div class="login-wrapper">
        <div class="login-form">
                <form class="form-horizontal" method="POST" action="/admin/confirm-password">
                        {{ csrf_field() }}
                    <div class="content-box">
                        <div class="card-title"><h1>Confirm password</h1></div>
                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">Password</label>
                            <input id="password" type="password" class="form-control" name="password" placeholder="" autocomplete="off" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-default login btn-primary mt-4">Confirm</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
@endsection
