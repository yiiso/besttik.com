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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->segment(1);
        
        if (in_array($locale, ['zh', 'en', 'es'])) {
            app()->setLocale($locale);
        } else {
            app()->setLocale('zh'); // 默认中文
        }
        
        return $next($request);
    }
}
