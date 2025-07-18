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
        $locale = $locale ?: app()->getLocale();
        
        // 如果是英文，使用默认路由（不带语言前缀）
        if ($locale === 'en') {
            return url($path);
        }
        
        // 其他语言使用带语言前缀的路由
        $path = ltrim($path, '/');
        return url("/{$locale}" . ($path ? "/{$path}" : ''));
    }
}