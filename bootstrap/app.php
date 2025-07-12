<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'alreadyLogin' => \App\Http\Middleware\alreadyLogin::class,
            'loginCheck' => \App\Http\Middleware\loginCheck::class,
            'preventBackHistory' => \App\Http\Middleware\preventBackHistory::class,
            'rememberMe' => \App\Http\Middleware\rememberMe::class,
            'handleServerError' => \App\Http\Middleware\handleServerError::class,
            'storeRequestLogs' => \App\Http\Middleware\storeRequestLogs::class,
            'accessManagement' => \App\Http\Middleware\accessManagement::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
