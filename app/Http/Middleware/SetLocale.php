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
        
        if (in_array($locale, ['zh', 'en', 'es', 'fr', 'ja'])) {
            app()->setLocale($locale);
        } else {
            // 检查用户设置的语言偏好（cookie）
            $preferredLocale = $request->cookie('language');
            
            if ($preferredLocale && in_array($preferredLocale, ['zh', 'en', 'es', 'fr', 'ja'])) {
                app()->setLocale($preferredLocale);
            } else {
                // 根据浏览器语言设置默认语言
                $browserLocale = $this->getBrowserLocale($request);
                app()->setLocale($browserLocale);
            }
        }
        
        return $next($request);
    }

    /**
     * 根据浏览器Accept-Language头获取首选语言
     */
    private function getBrowserLocale(Request $request): string
    {
        $acceptLanguage = $request->header('Accept-Language', '');
        
        // 解析Accept-Language头
        if (preg_match('/^([a-z]{2})/i', $acceptLanguage, $matches)) {
            $browserLang = strtolower($matches[1]);
            
            // 映射浏览器语言到支持的语言
            $supportedLocales = [
                'zh' => 'zh',
                'en' => 'en', 
                'es' => 'es',
                'fr' => 'fr',
                'ja' => 'ja'
            ];
            
            if (isset($supportedLocales[$browserLang])) {
                return $supportedLocales[$browserLang];
            }
        }
        
        // 默认英文
        return 'en';
    }
}
