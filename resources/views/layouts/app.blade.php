<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel quickstart'))</title>
    <script>
        window.base_url = "{{ url('/') }}";
    </script>
     @stack('scripts_top')
     @vite(['resources/css/frontend.css', 'resources/js/frontend.js'])
    @stack('scripts')
</head>
<body>

    @section('header')
        @include('layouts.includes.header')
    @show

    <div class="container-fluid">
         @include('shared.flash-messages')
         @yield('content')
    </div>

    @section('footer')
        @include('layouts.includes.footer')
    @show

</body>
</html>
