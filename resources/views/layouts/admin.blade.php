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
    <div class="container-fluid">
        <div class="row">
        @include('admin.includes.sidebar-left')
        @include('admin/includes/navbar')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            @include('admin.includes.messages')
            @yield('content')
        </main>
</body>
</html>
