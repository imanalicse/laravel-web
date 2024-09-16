<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckUserRoleMiddleware::class
        ]);

        $middleware->web(append: [
           \App\Http\Middleware\LoginPageRedirection::class
        ]);

        $middleware->validateCsrfTokens(except: [
            'stripe/*',
            'http://example.com/foo/bar',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
//        $exceptions->dontReportDuplicates();
//        $exceptions->stopIgnoring(HttpException::class);
    })->create();
