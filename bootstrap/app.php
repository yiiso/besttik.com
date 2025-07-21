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
        $middleware->append([

        ]);

        // 将推荐码中间件应用到web路由组
        $middleware->web(append: [
            'detect.language' => \App\Http\Middleware\DetectLanguage::class,
            'set.locale' => \App\Http\Middleware\SetLocale::class,
            \App\Http\Middleware\HandleReferralCode::class,
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
