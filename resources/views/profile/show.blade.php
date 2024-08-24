@extends('layouts.app')

@section('content')
Profile content

<a class="dropdown-item" href="{{ route('logout') }}"
   onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
    Logout
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>

@endsection
