<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel quickstart') }}</title>
    <script type="text/javascript" src="https://api.quickstream.support.qvalent.com/rest/v1/quickstream-api-1.0.min.js"></script>
     @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container-fluid">
        <header>
            Header
        </header>
        <div class="content">
            @yield('content')
        </div>
        <footer>
            Footer
        </footer>
    </div>
</body>
</html>
