<?php

use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Role gate middleware, usable as ->middleware('role:admin')
        $middleware->alias([
            'role' => \App\Http\Middleware\EnsureUserRole::class,
        ]);

        // Security headers on every web response.
        $middleware->web(append: [
            SecurityHeaders::class,
        ]);

        // Trust Railway's reverse proxy so HTTPS / client IP are detected correctly.
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
