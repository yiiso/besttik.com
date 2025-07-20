<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="referrer" content="never">
    <meta name="baidu-site-verification" content="codeva-pCWdn1qnj4" />
    <!-- SEO Meta Tags -->
    <title>@yield('title', __('messages.title'))</title>
    <meta name="description" content="@yield('description', __('messages.description'))">
    <meta name="keywords" content="@yield('keywords', __('messages.keywords'))">
    <meta name="author" content="VideoParser.top">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <!-- Open Graph Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('og_title', __('messages.title'))">
    <meta property="og:description" content="@yield('og_description', __('messages.description'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="VideoParser.top">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="{{ app()->getLocale() == 'zh' ? 'zh_CN' : app()->getLocale().'_'.strtoupper(app()->getLocale()) }}">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', __('messages.title'))">
    <meta name="twitter:description" content="@yield('twitter_description', __('messages.description'))">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/twitter-card.jpg'))">
    <meta name="twitter:site" content="@videoparser_top">

    <!-- Canonical URL -->
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- Hreflang Tags -->
    <link rel="alternate" hreflang="en" href="{{ str_replace('/'.app()->getLocale().'/', '/en/', url()->current()) }}">
    <link rel="alternate" hreflang="zh" href="{{ str_replace('/'.app()->getLocale().'/', '/zh/', url()->current()) }}">
    <link rel="alternate" hreflang="es" href="{{ str_replace('/'.app()->getLocale().'/', '/es/', url()->current()) }}">
    <link rel="alternate" hreflang="fr" href="{{ str_replace('/'.app()->getLocale().'/', '/fr/', url()->current()) }}">
    <link rel="alternate" hreflang="ja" href="{{ str_replace('/'.app()->getLocale().'/', '/ja/', url()->current()) }}">
    <link rel="alternate" hreflang="x-default" href="{{ str_replace('/'.app()->getLocale().'/', '/', url()->current()) }}">
    @verbatim
    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebApplication",
        "name": "VideoParser.top",
        "description": "{{ __('messages.description') }}",
        "url": "https://videoparser.top",
        "applicationCategory": "MultimediaApplication",
        "operatingSystem": "Web Browser",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "USD"
        },
        "creator": {
            "@type": "Organization",
            "name": "VideoParser.top",
            "url": "https://videoparser.top"
        },
        "featureList": [
            "YouTube video download",
            "TikTok video download",
            "Instagram video download",
            "Facebook video download",
            "Twitter video download",
            "Batch video processing",
            "Multiple format support",
            "High quality downloads"
        ],
        "screenshot": "{{ asset('images/app-screenshot.jpg') }}",
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.8",
            "reviewCount": "2847"
        }
    }
    </script>
    @endverbatim
    <!-- 包含结构化数据 -->
    @include('components.structured-data')

    <!-- 包含分析代码 -->
    @include('components.analytics')

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Pass translations to JavaScript -->
    <script>
        window.translations = {
            parse_success: "{{ __('messages.parse_success') }}",
            parse_failed: "{{ __('messages.parse_failed') }}",
            download_video: "{{ __('messages.download_video') }}",
            download_audio: "{{ __('messages.download_audio') }}",
            copy_link: "{{ __('messages.copy_link') }}",
            open_new_tab: "{{ __('messages.open_new_tab') }}",
            download_options: "{{ __('messages.download_options') }}",
            audio_download_options: "{{ __('messages.audio_download_options') }}",
            download: "{{ __('messages.download') }}",
            original_quality: "{{ __('messages.original_quality') }}",
            unknown_size: "{{ __('messages.unknown_size') }}",
            unknown_author: "{{ __('messages.unknown_author') }}",
            audio_quality: "{{ __('messages.audio_quality') }}",
            video_link_unavailable: "{{ __('messages.video_link_unavailable') }}",
            link_copied: "{{ __('messages.link_copied') }}",
            copy_failed: "{{ __('messages.copy_failed') }}",
            loading_video: "{{ __('messages.loading_video') }}",
            play_failed: "{{ __('messages.play_failed') }}",
            browser_not_support: "{{ __('messages.browser_not_support') }}",
            network_error: "{{ __('messages.network_error') }}",
            login_success: "{{ __('messages.login_success') }}",
            login_failed: "{{ __('messages.login_failed') }}",
            register: "{{ __('messages.register') }}",
            register_success: "{{ __('messages.register_success') }}",
            register_failed: "{{ __('messages.register_failed') }}",
            email_required: "{{ __('messages.email_required') }}",
            password_confirmation_failed: "{{ __('messages.password_confirmation_failed') }}",
            password_min_length: "{{ __('messages.password_min_length') }}",
            logout_success: "{{ __('messages.logout_success') }}",
            logout_confirm: "{{ __('messages.logout_confirm') }}",
            // Parse limit related translations
            daily_limit_exceeded_guest: "{{ __('messages.daily_limit_exceeded_guest') }}",
            daily_limit_exceeded_user: "{{ __('messages.daily_limit_exceeded_user') }}",
            remaining_parses: "{{ __('messages.remaining_parses') }}",
            parse_limit_info: "{{ __('messages.parse_limit_info') }}",
            guest_daily_limit: "{{ __('messages.guest_daily_limit') }}",
            user_daily_limit: "{{ __('messages.user_daily_limit') }}",
            login_for_more: "{{ __('messages.login_for_more') }}",
            upgrade_limit_info: "{{ __('messages.upgrade_limit_info') }}",
            login: "{{ __('messages.login') }}",
            close: "{{ __('messages.close') }}",
            platform: "{{ __('messages.platform') }}",
            audio_preview: "{{ __('messages.audio_preview') }}",
            video_not_supported: "{{ __('messages.video_not_supported') }}",
            audio_not_supported: "{{ __('messages.audio_not_supported') }}",
            quality_options: "{{ __('messages.quality_options') }}",
            audio_options: "{{ __('messages.audio_options') }}",
            recommended: "{{ __('messages.recommended') }}",
            video_load_error: "{{ __('messages.video_load_error') }}",
            // Paste button related translations
            paste: "{{ __('messages.paste') }}",
            paste_from_clipboard: "{{ __('messages.paste_from_clipboard') }}",
            paste_success: "{{ __('messages.paste_success') }}",
            paste_failed: "{{ __('messages.paste_failed') }}",
            clipboard_empty: "{{ __('messages.clipboard_empty') }}",
            clipboard_not_supported: "{{ __('messages.clipboard_not_supported') }}"
        };
    </script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8LCL71L7BH"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-8LCL71L7BH');
    </script>
</head>
<body class="bg-white text-gray-900 font-elegant antialiased">
    <!-- Header -->
    <header class="py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <a href="{{ localized_url('/') }}" class="flex items-center space-x-2">
                        <div class="w-10 h-10 flex items-center justify-center">
                            <svg class="w-10 h-10" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="headerGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#F472B6" />
                                        <stop offset="50%" stop-color="#8B5CF6" />
                                        <stop offset="100%" stop-color="#3B82F6" />
                                    </linearGradient>
                                    <filter id="headerNeonGlow" x="-20%" y="-20%" width="140%" height="140%">
                                        <feGaussianBlur stdDeviation="1" result="blur" />
                                        <feFlood flood-color="#F472B6" flood-opacity="0.5" result="glowColor" />
                                        <feComposite in="glowColor" in2="blur" operator="in" result="softGlow" />
                                        <feComposite in="softGlow" in2="SourceGraphic" operator="over" />
                                    </filter>
                                    <clipPath id="headerHexClip">
                                        <path d="M16 2L30 10V22L16 30L2 22V10L16 2Z" />
                                    </clipPath>
                                </defs>

                                <!-- 主背景 - 六边形 -->
                                <path d="M16 2L30 10V22L16 30L2 22V10L16 2Z" fill="url(#headerGradient)" />

                                <!-- 装饰图案 - 网格线 -->
                                <g clip-path="url(#headerHexClip)" opacity="0.15">
                                    <path d="M0 8H32M0 16H32M0 24H32" stroke="white" stroke-width="0.5" />
                                    <path d="M8 0V32M16 0V32M24 0V32" stroke="white" stroke-width="0.5" />
                                </g>

                                <!-- 中心图形 - 现代播放图标 -->
                                <g filter="url(#headerNeonGlow)">
                                    <!-- 播放三角形 - 不规则形状 -->
                                    <path d="M12 10L22 16L12 22V10Z" fill="white" />

                                    <!-- 装饰元素 - 垂直线 -->
                                    <path d="M10 10V22" stroke="white" stroke-width="2" stroke-linecap="round" />
                                </g>

                                <!-- 边缘高光 -->
                                <path d="M16 2L30 10V22L16 30L2 22V10L16 2Z" fill="none" stroke="white" stroke-width="0.5" stroke-opacity="0.8" />
                            </svg>
                        </div>
                        <span class="text-xl font-semibold text-gray-900 heading-modern">VideoParser.top</span>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <select id="languageSelect" class="text-sm border-0 bg-transparent text-gray-600 focus:ring-0 cursor-pointer ui-text font-medium">
                        <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }} class="ui-text">English</option>
                        <option value="zh" {{ app()->getLocale() == 'zh' ? 'selected' : '' }} class="ui-text">中文</option>
                        <option value="es" {{ app()->getLocale() == 'es' ? 'selected' : '' }} class="ui-text">Español</option>
                        <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }} class="ui-text">Français</option>
                        <option value="ja" {{ app()->getLocale() == 'ja' ? 'selected' : '' }} class="ui-text">日本語</option>
                    </select>

                    @auth
                        <!-- 用户已登录状态 -->
                        <div class="relative" id="userMenu">
                            <button id="userMenuBtn" class="flex items-center space-x-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors ui-text">
                                @if(auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-6 h-6 rounded-full">
                                @else
                                    <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center">
                                        <span class="text-white text-xs font-medium">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                                <span class="text-gray-700">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- 下拉菜单 -->
                            <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                                <div class="py-2">
                                    <div class="px-4 py-2 border-b border-gray-100">
                                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                        <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                                    </div>
                                    <a href="{{ localized_url('/dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                        {{ __('messages.dashboard_title') }}
                                    </a>
                                    <div class="border-t border-gray-100 mt-2 pt-2">
                                        <button id="logoutBtn" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            {{ __('messages.logout') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- 用户未登录状态 -->
                        <button id="loginBtn" class="flex items-center space-x-2 px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-lg transition-all duration-200 ui-text group">
                            <svg class="w-4 h-4 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-sm font-medium">{{ __('messages.login') }}</span>
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Breadcrumb Navigation -->
    @include('components.breadcrumb')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-10 h-10 flex items-center justify-center">
                            <svg class="w-10 h-10" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="footerGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#F472B6" />
                                        <stop offset="50%" stop-color="#8B5CF6" />
                                        <stop offset="100%" stop-color="#3B82F6" />
                                    </linearGradient>
                                    <filter id="footerNeonGlow" x="-20%" y="-20%" width="140%" height="140%">
                                        <feGaussianBlur stdDeviation="1" result="blur" />
                                        <feFlood flood-color="#F472B6" flood-opacity="0.5" result="glowColor" />
                                        <feComposite in="glowColor" in2="blur" operator="in" result="softGlow" />
                                        <feComposite in="softGlow" in2="SourceGraphic" operator="over" />
                                    </filter>
                                    <clipPath id="footerHexClip">
                                        <path d="M16 2L30 10V22L16 30L2 22V10L16 2Z" />
                                    </clipPath>
                                </defs>

                                <!-- 主背景 - 六边形 -->
                                <path d="M16 2L30 10V22L16 30L2 22V10L16 2Z" fill="url(#footerGradient)" />

                                <!-- 装饰图案 - 网格线 -->
                                <g clip-path="url(#footerHexClip)" opacity="0.15">
                                    <path d="M0 8H32M0 16H32M0 24H32" stroke="white" stroke-width="0.5" />
                                    <path d="M8 0V32M16 0V32M24 0V32" stroke="white" stroke-width="0.5" />
                                </g>

                                <!-- 中心图形 - 现代播放图标 -->
                                <g filter="url(#footerNeonGlow)">
                                    <!-- 播放三角形 - 不规则形状 -->
                                    <path d="M12 10L22 16L12 22V10Z" fill="white" />

                                    <!-- 装饰元素 - 垂直线 -->
                                    <path d="M10 10V22" stroke="white" stroke-width="2" stroke-linecap="round" />
                                </g>

                                <!-- 边缘高光 -->
                                <path d="M16 2L30 10V22L16 30L2 22V10L16 2Z" fill="none" stroke="white" stroke-width="0.5" stroke-opacity="0.8" />
                            </svg>
                        </div>
                        <span class="text-xl font-semibold text-gray-900 heading-modern">VideoParser.top</span>
                    </div>
                    <p class="text-gray-600 max-w-md body-light">
                        {{ __('messages.footer_description') }}
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900 mb-4 heading-modern">{{ __('messages.navigation') }}</h3>
                    <ul class="space-y-2 text-gray-600 body-light">
                        <li><a href="#features" class="hover:text-gray-900 transition-colors">{{ __('messages.why_choose_us') }}</a></li>
                        <li><a href="#supported" class="hover:text-gray-900 transition-colors">{{ __('messages.supported_platforms') }}</a></li>
                        <li><a href="#how-to-use" class="hover:text-gray-900 transition-colors">{{ __('messages.how_to_use') }}</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900 mb-4 heading-modern">{{ __('messages.products') }}</h3>
                    <ul class="space-y-2 text-gray-600 body-light">
                        <li><a href="{{ localized_url('/') }}" class="hover:text-gray-900 transition-colors">{{ __('messages.video_parser') }}</a></li>
                        <li><a href="{{ localized_url('/batch-download') }}" class="hover:text-gray-900 transition-colors">{{ __('messages.batch_download') }}</a></li>
                        <li><a href="{{ localized_url('/api') }}" class="hover:text-gray-900 transition-colors">{{ __('messages.api_service') }}</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900 mb-4 heading-modern">{{ __('messages.support') }}</h3>
                    <ul class="space-y-2 text-gray-600 body-light">
                        <li><a href="{{ localized_url('/help') }}" class="hover:text-gray-900 transition-colors">{{ __('messages.help_center') }}</a></li>
                        <li><a href="{{ localized_url('/contact') }}" class="hover:text-gray-900 transition-colors">{{ __('messages.contact_us') }}</a></li>
                        <li><a href="{{ localized_url('/privacy') }}" class="hover:text-gray-900 transition-colors">{{ __('messages.privacy_policy') }}</a></li>
                        <li><a href="{{ localized_url('/terms') }}" class="hover:text-gray-900 transition-colors">{{ __('messages.terms_of_service') }}</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-200 mt-8 pt-8 text-center text-gray-600">
                <p class="body-light">&copy; {{ date('Y') }} VideoParser.top. {{ __('messages.all_rights_reserved') }}</p>
            </div>
        </div>
    </footer>

    <!-- 登录弹窗 -->
    <div id="loginModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="loginModalContent">
            <!-- 关闭按钮 -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-900 heading-modern">{{ __('messages.login') }}</h2>
                <button id="closeLoginModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- 登录选项 -->
            <div class="space-y-4">
                <!-- Google 登录 -->
                <button id="googleLoginBtn" class="w-full flex items-center justify-center space-x-3 px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span class="ui-text">{{ __('messages.login_with_google') }}</span>
                </button>

                <!-- 分割线 -->
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">{{ __('messages.or') }}</span>
                    </div>
                </div>

                <!-- 邮箱登录表单 -->
                <form id="emailLoginForm" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.email') }}</label>
                        <input type="email" id="email" name="email" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                               placeholder="{{ __('messages.enter_email') }}">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.password') }}</label>
                        <input type="password" id="password" name="password" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                               placeholder="{{ __('messages.enter_password') }}">
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-600">{{ __('messages.remember_me') }}</span>
                        </label>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-500">{{ __('messages.forgot_password') }}</a>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg transition-colors ui-text">
                        {{ __('messages.login') }}
                    </button>
                </form>

                <!-- 注册链接 -->
                <div class="text-center">
                    <span class="text-sm text-gray-600">{{ __('messages.no_account') }}</span>
                    <a href="#" id="showRegisterForm" class="text-sm text-blue-600 hover:text-blue-500 ml-1">{{ __('messages.register_now') }}</a>
                </div>
            </div>

            <!-- 注册表单 (默认隐藏) -->
            <div id="registerFormContainer" class="hidden space-y-4">
                <form id="emailRegisterForm" class="space-y-4">
                    @csrf


                    <div>
                        <label for="register_email" class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.email') }}</label>
                        <input type="email" id="register_email" name="email" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                               placeholder="{{ __('messages.enter_email') }}">
                    </div>

                    <div>
                        <label for="register_password" class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.password') }}</label>
                        <input type="password" id="register_password" name="password" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                               placeholder="{{ __('messages.enter_password') }}">
                    </div>

                    <div>
                        <label for="register_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.confirm_password') }}</label>
                        <input type="password" id="register_password_confirmation" name="password_confirmation" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                               placeholder="{{ __('messages.confirm_password') }}">
                    </div>

                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg transition-colors ui-text">
                        {{ __('messages.register') }}
                    </button>
                </form>

                <!-- 返回登录链接 -->
                <div class="text-center">
                    <span class="text-sm text-gray-600">{{ __('messages.already_have_account') }}</span>
                    <a href="#" id="showLoginForm" class="text-sm text-blue-600 hover:text-blue-500 ml-1">{{ __('messages.back_to_login') }}</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
