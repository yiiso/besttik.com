<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next)
    {
        $defaultLocale = config('app.default_locale');
        $supportedLocales = array_keys(config('app.locales'));

        // 1. 从URL获取语言段（如果有）
        $locale = $request->segment(1);
        if ($locale == app()->getLocale()) {
           return $next($request);
        }

        // 2. 检查URL语言段是否有效
        if (in_array($locale, $supportedLocales) && $locale !== $defaultLocale) {
            app()->setLocale($locale);
            // 从请求中移除语言段，避免影响路由匹配
            $request->route()->forgetParameter($locale);
        } // 3. 无前缀URL默认使用英文
        else {
            app()->setLocale($defaultLocale);
        }

        return $next($request)->cookie('locale',$locale,60*24*365);
    }
}

