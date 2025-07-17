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
</head>
<body class="bg-white text-gray-900 font-sans antialiased">
    <!-- Header -->
    <header class="border-b border-gray-200">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 6a2 2 0 012-2h6l2 2h6a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 10-3 3m0 0-3-3m3 3V4"/>
                            </svg>
                        </div>
                        <span class="text-xl font-semibold text-gray-900">VideoParser.pro</span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-gray-900 transition-colors">功能特点</a>
                    <a href="#supported" class="text-gray-600 hover:text-gray-900 transition-colors">支持平台</a>
                    <a href="#about" class="text-gray-600 hover:text-gray-900 transition-colors">关于我们</a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <select class="text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="zh">中文</option>
                        <option value="en">English</option>
                        <option value="ja">日本語</option>
                        <option value="ko">한국어</option>
                    </select>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 6a2 2 0 012-2h6l2 2h6a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 10-3 3m0 0-3-3m3 3V4"/>
                            </svg>
                        </div>
                        <span class="text-xl font-semibold text-gray-900">VideoParser.pro</span>
                    </div>
                    <p class="text-gray-600 max-w-md">
                        专业的全球视频解析工具，为用户提供快速、安全、便捷的视频链接解析服务。
                    </p>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">产品</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="#" class="hover:text-gray-900 transition-colors">视频解析</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition-colors">批量下载</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition-colors">API服务</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">支持</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="#" class="hover:text-gray-900 transition-colors">使用帮助</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition-colors">联系我们</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition-colors">隐私政策</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-200 mt-8 pt-8 text-center text-gray-600">
                <p>&copy; {{ date('Y') }} VideoParser.pro. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>