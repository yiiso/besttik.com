<?php

if (!function_exists('localized_url')) {
    /**
     * Generate a localized URL based on the current locale
     *
     * @param string $path
     * @param string|null $locale
     * @return string
     */
    function localized_url($path = '', $locale = null)
    {
        $defaultLocale = config('app.default_locale');
        $locale = $locale ?: app()->getLocale();

        if ($locale === $defaultLocale) {
            return url($path);
        }

        return url("/{$locale}{$path}");
    }
}


if (!function_exists('locale_url')) {
    /**
     * 生成带语言前缀的URL
     * @param string $locale 语言代码
     * @param string $path 路径（默认当前路径）
     * @return string
     */
    function locale_url($locale, $path = null)
    {
        $defaultLocale = config('app.default_locale');
        $path = $path ?? request()->getPathInfo(); // 当前路径（不含域名）

        // 移除路径中可能存在的旧语言前缀（避免重复）
        $supportedLocales = array_keys(config('app.locales'));
        foreach ($supportedLocales as $lang) {
            if ($lang !== $defaultLocale && str_starts_with($path, "/{$lang}")) {
                $path = substr($path, strlen("/{$lang}"));
                break;
            }
        }

        // 生成URL
        if ($locale === $defaultLocale) {
            return url($path ?: '/'); // 默认语言无前缀
        } else {
            return url("/{$locale}{$path}"); // 其他语言加前缀
        }
    }
}

if (!function_exists('get_alternate_urls')) {
    /**
     * Get alternate URLs for all supported languages
     *
     * @param string $path
     * @return array
     */
    function get_alternate_urls($path = '')
    {
        $languages = ['en', 'zh', 'es', 'fr', 'ja'];
        $alternates = [];

        foreach ($languages as $lang) {
            $alternates[$lang] = localized_url($path, $lang);
        }

        return $alternates;
    }
}

if (!function_exists('get_canonical_url')) {
    /**
     * Get canonical URL for current page
     *
     * @return string
     */
    function get_canonical_url()
    {
        $currentUrl = url()->current();

        // Remove query parameters for canonical URL
        $parsedUrl = parse_url($currentUrl);
        $canonicalUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];

        if (isset($parsedUrl['port'])) {
            $canonicalUrl .= ':' . $parsedUrl['port'];
        }

        if (isset($parsedUrl['path'])) {
            $canonicalUrl .= $parsedUrl['path'];
        }

        return $canonicalUrl;
    }
}

if (!function_exists('generate_meta_description')) {
    /**
     * Generate meta description based on page content
     *
     * @param string $content
     * @param int $length
     * @return string
     */
    function generate_meta_description($content, $length = 160)
    {
        $content = strip_tags($content);
        $content = preg_replace('/\s+/', ' ', $content);
        $content = trim($content);

        if (strlen($content) <= $length) {
            return $content;
        }

        return substr($content, 0, $length - 3) . '...';
    }
}

if (!function_exists('get_supported_platforms')) {
    /**
     * Get list of supported video platforms
     *
     * @return array
     */
    function get_supported_platforms()
    {
        return [
            'youtube' => [
                'name' => 'YouTube',
                'icon' => 'youtube',
                'color' => 'red-600',
                'url' => 'https://youtube.com'
            ],
            'tiktok' => [
                'name' => 'TikTok',
                'icon' => 'tiktok',
                'color' => 'black',
                'url' => 'https://tiktok.com'
            ],
            'instagram' => [
                'name' => 'Instagram',
                'icon' => 'instagram',
                'color' => 'pink-600',
                'url' => 'https://instagram.com'
            ],
            'facebook' => [
                'name' => 'Facebook',
                'icon' => 'facebook',
                'color' => 'blue-600',
                'url' => 'https://facebook.com'
            ],
            'twitter' => [
                'name' => 'Twitter',
                'icon' => 'twitter',
                'color' => 'blue-400',
                'url' => 'https://twitter.com'
            ],
            'bilibili' => [
                'name' => 'Bilibili',
                'icon' => 'bilibili',
                'color' => 'blue-500',
                'url' => 'https://bilibili.com'
            ],
            'douyin' => [
                'name' => 'Douyin',
                'icon' => 'douyin',
                'color' => 'black',
                'url' => 'https://douyin.com'
            ]
        ];
    }
}
if (!function_exists('beijing_time')) {
    /**
     * 获取北京时间
     *
     * @param string|null $format 时间格式
     * @return string|\Carbon\Carbon
     */
    function beijing_time($format = null)
    {
        $beijingTime = \Carbon\Carbon::now('Asia/Shanghai');

        return $format ? $beijingTime->format($format) : $beijingTime;
    }
}

if (!function_exists('format_beijing_time')) {
    /**
     * 格式化为北京时间显示
     *
     * @param mixed $time
     * @param string $format
     * @return string
     */
    function format_beijing_time($time, $format = 'Y-m-d H:i:s')
    {
        if (!$time) {
            return '';
        }

        $carbon = $time instanceof \Carbon\Carbon ? $time : \Carbon\Carbon::parse($time);

        return $carbon->setTimezone('Asia/Shanghai')->format($format);
    }
}
if (!function_exists('get_client_ip')) {
    /**
     * 获取客户端真实IP地址
     */
    function get_client_ip()
    {
        $ipKeys = ['HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'HTTP_CLIENT_IP', 'REMOTE_ADDR'];

        foreach ($ipKeys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                $ip = $_SERVER[$key];
                if (strpos($ip, ',') !== false) {
                    $ip = explode(',', $ip)[0];
                }
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }

        return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }
}
