<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'NSW') }}</title>

    <script src="{{asset('src/frontend/js/vendor/jquery-1.9.1.min.js')}}"></script>
    <script src="{{asset('src/frontend/js/vendor/jquery-validation/jquery.validate.js')}}"></script>
    <script src="{{asset('src/frontend/js/vendor/jquery-validation/additional-methods.min.js')}}"></script>
    <script src="{{asset('src/frontend/js/bootstrap.min.js')}}"></script>

    <link rel="stylesheet" href="{{asset('src/frontend/css/normalize.css')}}">
    <link rel="stylesheet" href="{{asset('src/frontend/css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{asset('src/frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('src/frontend/css/main.css?v=')}}">
    <script src="{{asset('src/frontend/js/vendor/modernizr-2.8.3.min.js')}}"></script>

</head>
<body>
    <div id="app">
        <header>
            Header
        </header>
        <div class="container">
            @yield('content')
        </div>

        <footer>
            Footer
        </footer>
    </div>
</body>
</html>
