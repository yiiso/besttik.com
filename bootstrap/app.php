<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as RequestAlias;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'detect.language' => \App\Http\Middleware\DetectLanguage::class,
            'set.locale' => \App\Http\Middleware\SetLocale::class,
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'admin.auth' => \App\Http\Middleware\AdminAuth::class,
            'set.timezone' => \App\Http\Middleware\SetTimezone::class,
        ]);
        //获取真实代理后的ip
        $middleware->trustProxies(
            at: [
                // Cloudflare IPv4
                '173.245.48.0/20',
                '103.21.244.0/22',
                '103.22.200.0/22',
                '103.31.4.0/22',
                '141.101.64.0/18',
                '108.162.192.0/18',
                '190.93.240.0/20',
                '188.114.96.0/20',
                '197.234.240.0/22',
                '198.41.128.0/17',
                '162.158.0.0/15',
                '104.16.0.0/12',
                '172.64.0.0/13',
                '131.0.72.0/22',

                // Cloudflare IPv6
                '2400:cb00::/32',
                '2606:4700::/32',
                '2803:f800::/32',
                '2405:b500::/32',
                '2405:8100::/32',
                '2a06:98c0::/29',
                '2c0f:f248::/32',
            ],headers: RequestAlias::HEADER_X_FORWARDED_FOR |
            RequestAlias::HEADER_X_FORWARDED_HOST |
            RequestAlias::HEADER_X_FORWARDED_PORT |
            RequestAlias::HEADER_X_FORWARDED_PROTO
        );

        // 将推荐码中间件应用到web路由组
        $middleware->web(append: [


            \App\Http\Middleware\HandleReferralCode::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
