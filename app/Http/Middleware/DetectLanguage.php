<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DetectLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 获取当前路径
        $path = $request->path();

        // 支持的语言列表
        $supportedLanguages = ['zh', 'en', 'es', 'fr', 'ja'];
        
        // 首先设置当前请求的locale
        $this->setCurrentLocale($request, $supportedLanguages);
        
        $targetLang = $request->language ?? null;
        if($targetLang && in_array($targetLang ,$supportedLanguages)){
            $segments = explode('/',ltrim($path,'/'));
            if (!empty($segments[0]) && in_array($segments[0],$supportedLanguages)) {
                // 替换现有语言前缀
                if ($targetLang == 'en') {
                    unset($segments[0]);
                }else{
                    $segments[0] = $targetLang;
                }
            } else {
                if ($targetLang !='en'){
                    array_unshift($segments, $targetLang);
                }
            }
            $target = implode('/',$segments);
            $response = redirect("/{$target}");
            $response->withCookie(cookie('user_language_selected', true, 60 * 24 * 30));
            return $response;
        }

        // 如果不是根路径，则不处理重定向逻辑
        if ($path !== '/') {
            return $next($request);
        }

        // 检查用户是否已经手动选择过语言（通过cookie标记）
        if ($request->hasCookie('user_language_selected')) {
            // 用户已经手动选择过语言，不再自动跳转
            return $next($request);
        }

        // 用户第一次访问，根据浏览器语言自动跳转
        $browserLanguages = $this->getBrowserLanguages($request);

        // 匹配支持的语言
        foreach ($browserLanguages as $browserLang) {
            $detectedLang = $this->matchLanguage($browserLang, $supportedLanguages);
            if ($detectedLang && $detectedLang !== 'en') {
                // 自动跳转到检测到的语言，但不设置"用户已选择"标记
                return redirect("/{$detectedLang}");
            }
        }
        return $next($request);
    }

    /**
     * 设置当前请求的locale
     */
    private function setCurrentLocale(Request $request, array $supportedLanguages): void
    {
        $path = $request->path();
        $segments = explode('/', trim($path, '/'));
        
        // 检查URL中的语言前缀
        if (!empty($segments[0]) && in_array($segments[0], $supportedLanguages)) {
            app()->setLocale($segments[0]);
            return;
        }
        
        // 检查用户设置的语言偏好（cookie）
        $preferredLocale = $request->cookie('language');
        if ($preferredLocale && in_array($preferredLocale, $supportedLanguages)) {
            app()->setLocale($preferredLocale);
            return;
        }
        
        // 根据浏览器语言设置默认语言
        $browserLanguages = $this->getBrowserLanguages($request);
        foreach ($browserLanguages as $browserLang) {
            $detectedLang = $this->matchLanguage($browserLang, $supportedLanguages);
            if ($detectedLang) {
                app()->setLocale($detectedLang);
                return;
            }
        }
        
        // 默认英文
        app()->setLocale('en');
    }

    /**
     * 获取浏览器语言偏好列表
     */
    private function getBrowserLanguages(Request $request): array
    {
        $acceptLanguage = $request->header('Accept-Language');
        if (!$acceptLanguage) {
            return [];
        }

        $languages = [];
        $parts = explode(',', $acceptLanguage);

        foreach ($parts as $part) {
            $part = trim($part);
            if (strpos($part, ';') !== false) {
                [$lang, $quality] = explode(';', $part, 2);
                $quality = (float) str_replace('q=', '', $quality);
            } else {
                $lang = $part;
                $quality = 1.0;
            }

            $lang = trim($lang);
            $languages[$lang] = $quality;
        }

        // 按质量值排序
        arsort($languages);

        return array_keys($languages);
    }

    /**
     * 匹配语言代码
     */
    private function matchLanguage(string $browserLang, array $supportedLanguages): ?string
    {
        // 直接匹配
        if (in_array($browserLang, $supportedLanguages)) {
            return $browserLang;
        }

        // 提取主语言代码（如 zh-CN -> zh）
        $primaryLang = strtolower(substr($browserLang, 0, 2));
        if (in_array($primaryLang, $supportedLanguages)) {
            return $primaryLang;
        }

        // 特殊匹配规则
        $languageMap = [
            'zh-cn' => 'zh',
            'zh-tw' => 'zh',
            'zh-hk' => 'zh',
            'zh-sg' => 'zh',
            'en-us' => 'en',
            'en-gb' => 'en',
            'en-au' => 'en',
            'en-ca' => 'en',
            'es-es' => 'es',
            'es-mx' => 'es',
            'es-ar' => 'es',
            'fr-fr' => 'fr',
            'fr-ca' => 'fr',
            'ja-jp' => 'ja',
        ];

        $lowerBrowserLang = strtolower($browserLang);
        if (isset($languageMap[$lowerBrowserLang])) {
            return $languageMap[$lowerBrowserLang];
        }

        return null;
    }
}
