<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <?php
    $action = app('request')->route()->getAction();
    $controller = class_basename($action['controller']);
    list($controller, $action) = explode('@', $controller);
    ?>

    @include('admin.includes.sidebar')

    <div class="container">
        @include('admin/includes/navbar')
        <div class="main-container">
            @include('admin.includes.messages')
            @yield('content')
        </div>
    </div>
</body>
</html>
