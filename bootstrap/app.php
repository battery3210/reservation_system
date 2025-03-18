<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Routing\Middleware\ThrottleRequests;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        // // 認証ミドルウェアを追加
        // $middleware->push(Authenticate::class);
        // $middleware->push(ThrottleRequests::class); // 追加するミドルウェアをここに
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
