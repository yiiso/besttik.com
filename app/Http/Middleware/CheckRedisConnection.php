<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class CheckRedisConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // 测试Redis连接
            Redis::ping();
        } catch (\Exception $e) {
            // Redis连接失败时的处理
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Redis服务不可用，登录保护功能暂时关闭'
                ], 503);
            }
            
            // 可以选择继续执行但禁用登录保护，或者显示错误页面
            // 这里选择继续执行，但在视图中显示警告
            $request->attributes->set('redis_unavailable', true);
        }

        return $next($request);
    }
}