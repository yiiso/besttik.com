<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'VideoParser.pro - 全球视频解析工具')</title>
    <meta name="description" content="@yield('description', '专业的全球视频解析工具，支持多平台视频链接解析下载')">

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
            network_error: "{{ __('messages.network_error') }}"
        };
    </script>
</head>
<body class="bg-white text-gray-900 font-elegant antialiased">
    <!-- Header -->
    <header class="py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2">
                        <div class="w-10 h-10 flex items-center justify-center">
                            <svg class="w-10 h-10" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="headerGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#06B6D4" />
                                        <stop offset="50%" stop-color="#3B82F6" />
                                        <stop offset="100%" stop-color="#8B5CF6" />
                                    </linearGradient>
                                </defs>
                                <!-- 背景 - 不规则形状 -->
                                <path d="M2 8L16 2L30 8V24L16 30L2 24V8Z" fill="black" />
                                <path d="M4 9L16 4L28 9V23L16 28L4 23V9Z" fill="url(#headerGradient)" />
                                
                                <!-- 中心图形 - 抽象播放图标 -->
                                <path d="M13 10L22 16L13 22V10Z" fill="white" />
                                <path d="M10 10L10 22" stroke="white" stroke-width="1.5" stroke-linecap="round" />
                                
                                <!-- 装饰元素 - 点和线 -->
                                <circle cx="16" cy="4" r="1" fill="white" opacity="0.8" />
                                <circle cx="28" cy="16" r="1" fill="white" opacity="0.8" />
                                <circle cx="16" cy="28" r="1" fill="white" opacity="0.8" />
                                <circle cx="4" cy="16" r="1" fill="white" opacity="0.8" />
                            </svg>
                        </div>
                        <span class="text-xl font-semibold text-gray-900 heading-modern">VideoParser.pro</span>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <select id="languageSelect" class="text-sm border-0 bg-transparent text-gray-600 focus:ring-0 cursor-pointer">
                        <option value="zh" {{ app()->getLocale() == 'zh' ? 'selected' : '' }}>中文</option>
                        <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
                        <option value="es" {{ app()->getLocale() == 'es' ? 'selected' : '' }}>Español</option>
                        <option value="fr" {{ app()->getLocale() == 'fr' ? 'selected' : '' }}>Français</option>
                        <option value="ja" {{ app()->getLocale() == 'ja' ? 'selected' : '' }}>日本語</option>
                    </select>
                </div>
            </div>
        </div>
    </header>

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
                            <svg class="w-10 h-10" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="footerGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#06B6D4" />
                                        <stop offset="50%" stop-color="#3B82F6" />
                                        <stop offset="100%" stop-color="#8B5CF6" />
                                    </linearGradient>
                                </defs>
                                <!-- 背景 - 不规则形状 -->
                                <path d="M2 8L16 2L30 8V24L16 30L2 24V8Z" fill="black" />
                                <path d="M4 9L16 4L28 9V23L16 28L4 23V9Z" fill="url(#footerGradient)" />
                                
                                <!-- 中心图形 - 抽象播放图标 -->
                                <path d="M13 10L22 16L13 22V10Z" fill="white" />
                                <path d="M10 10L10 22" stroke="white" stroke-width="1.5" stroke-linecap="round" />
                                
                                <!-- 装饰元素 - 点和线 -->
                                <circle cx="16" cy="4" r="1" fill="white" opacity="0.8" />
                                <circle cx="28" cy="16" r="1" fill="white" opacity="0.8" />
                                <circle cx="16" cy="28" r="1" fill="white" opacity="0.8" />
                                <circle cx="4" cy="16" r="1" fill="white" opacity="0.8" />
                            </svg>
                        </div>
                        <span class="text-xl font-semibold text-gray-900 heading-modern">VideoParser.pro</span>
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
                        <li><a href="#" class="hover:text-gray-900 transition-colors">{{ __('messages.video_parser') }}</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition-colors">{{ __('messages.batch_download') }}</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition-colors">{{ __('messages.api_service') }}</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900 mb-4 heading-modern">{{ __('messages.support') }}</h3>
                    <ul class="space-y-2 text-gray-600 body-light">
                        <li><a href="#" class="hover:text-gray-900 transition-colors">{{ __('messages.help_center') }}</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition-colors">{{ __('messages.contact_us') }}</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition-colors">{{ __('messages.privacy_policy') }}</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition-colors">{{ __('messages.terms_of_service') }}</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-200 mt-8 pt-8 text-center text-gray-600">
                <p class="body-light">&copy; {{ date('Y') }} VideoParser.pro. {{ __('messages.all_rights_reserved') }}</p>
            </div>
        </div>
    </footer>
</body>
</html>
