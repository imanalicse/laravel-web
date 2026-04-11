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

    <main class="site-main">
         <div class="container-fluid px-0">
             @include('shared.flash-messages')
         </div>
         @yield('content')
    </main>

    @section('footer')
        @include('layouts.includes.footer')
    @show

</body>
</html>
