<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DetectLanguage
{
    public function handle(Request $request, Closure $next)
    {
        // 默认使用英文（无前缀）
        return $next($request);
    }
}
