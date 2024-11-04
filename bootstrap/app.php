<?php

use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\isAdmin;
use App\Http\Middleware\isGuest;
use App\Http\Middleware\isUser;
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
        $middleware->web(append: [
            HandleInertiaRequests::class
        ]);
        $middleware->alias([
            'isAdmin'=> isAdmin::class,
            'isUser'=> isUser::class,
            'isGuest'=> isGuest::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
