<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DetectLanguage
{
    public function handle(Request $request, Closure $next)
    {
        // 如果用户已有会话或手动选择了语言，不进行自动检测
        if ($request->session()->has('locale') || $request->segment(1)) {
            return $next($request);
        }

        $defaultLocale = config('app.default_locale');
        $supportedLocales = array_keys(config('app.locales'));

        // 从浏览器请求头获取语言
        $browserLocale = $request->server('HTTP_ACCEPT_LANGUAGE');

        if ($browserLocale) {
            // 解析浏览器语言（格式如：zh-CN,zh;q=0.9,en;q=0.8）
            $locales = explode(',', $browserLocale);
            foreach ($locales as $locale) {
                $locale = substr($locale, 0, 2); // 提取前两位（如zh-CN → zh）
                if (in_array($locale, $supportedLocales) && $locale !== $defaultLocale) {
                    // 重定向到带语言前缀的URL
                    return redirect()->to("/{$locale}{$request->getRequestUri()}");
                }
            }
        }

        // 默认使用英文（无前缀）
        return $next($request);
    }
}
