<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'VideoParser.pro - 全球视频解析工具')</title>
    <meta name="description" content="@yield('description', '专业的全球视频解析工具，支持多平台视频链接解析下载')">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Pass translations to JavaScript -->
    <script>

    </script>
</head>
<body class="bg-white text-gray-900 font-elegant antialiased">
    <!-- Header -->
    <header class="py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 6a2 2 0 012-2h6l2 2h6a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 10-3 3m0 0-3-3m3 3V4"/>
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
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 6a2 2 0 012-2h6l2 2h6a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 10-3 3m0 0-3-3m3 3V4"/>
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
