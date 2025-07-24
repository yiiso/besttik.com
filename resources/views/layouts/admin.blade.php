<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>@yield('title', '运营管理后台')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('css/mobile-admin.css') }}" rel="stylesheet">
    <style>
        /* 移动端导航栏样式 */
        @media (max-width: 768px) {
            .mobile-nav-toggle { display: block; }
            .desktop-nav { display: none; }
            .mobile-nav { display: none; }
            .mobile-nav.show { display: flex; }
        }
        @media (min-width: 769px) {
            .mobile-nav-toggle { display: none; }
            .desktop-nav { display: flex; }
            .mobile-nav { display: none; }
        }
    </style>
    @stack('head-scripts')
    @stack('styles')
</head>
<body class="bg-gray-100">
    <!-- 导航栏 -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- 桌面端导航 -->
            <div class="desktop-nav justify-between h-16">
                <div class="flex items-center space-x-8">
                    <h1 class="text-xl font-semibold text-gray-900">运营管理后台</h1>
                    <nav class="flex space-x-4">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="{{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-gray-900' }} px-3 py-2 rounded-md text-sm font-medium">
                            仪表板
                        </a>
                        <a href="{{ route('admin.parse-logs') }}" 
                           class="{{ request()->routeIs('admin.parse-logs*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-gray-900' }} px-3 py-2 rounded-md text-sm font-medium">
                            解析记录
                        </a>
                        <a href="{{ route('admin.security') }}" 
                           class="{{ request()->routeIs('admin.security*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-gray-900' }} px-3 py-2 rounded-md text-sm font-medium">
                            安全监控
                        </a>
                        <a href="{{ route('admin.profile') }}" 
                           class="{{ request()->routeIs('admin.profile*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-gray-900' }} px-3 py-2 rounded-md text-sm font-medium">
                            个人资料
                        </a>
                    </nav>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">欢迎，{{ Auth::guard('admin')->user()->name }}</span>
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800">退出登录</button>
                    </form>
                </div>
            </div>
            
            <!-- 移动端导航 -->
            <div class="md:hidden">
                <div class="flex justify-between items-center h-16">
                    <h1 class="text-lg font-semibold text-gray-900">@yield('mobile-title', '运营后台')</h1>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600 hidden sm:block">{{ Auth::guard('admin')->user()->name }}</span>
                        <button class="mobile-nav-toggle p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100" onclick="toggleMobileNav()">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- 移动端菜单 -->
                <div class="mobile-nav flex-col space-y-2 pb-4 border-t border-gray-200">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="{{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} px-4 py-3 rounded-md text-sm font-medium block">
                        仪表板
                    </a>
                    <a href="{{ route('admin.parse-logs') }}" 
                       class="{{ request()->routeIs('admin.parse-logs*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} px-4 py-3 rounded-md text-sm font-medium block">
                        解析记录
                    </a>
                    <a href="{{ route('admin.security') }}" 
                       class="{{ request()->routeIs('admin.security*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} px-4 py-3 rounded-md text-sm font-medium block">
                        安全监控
                    </a>
                    <a href="{{ route('admin.profile') }}" 
                       class="{{ request()->routeIs('admin.profile*') ? 'bg-blue-100 text-blue-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} px-4 py-3 rounded-md text-sm font-medium block">
                        个人资料
                    </a>
                    <div class="border-t border-gray-200 pt-2">
                        <div class="px-4 py-2 text-sm text-gray-600">欢迎，{{ Auth::guard('admin')->user()->name }}</div>
                        <form method="POST" action="{{ route('admin.logout') }}" class="px-4">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">退出登录</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- 主要内容区域 -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @yield('content')
    </div>

    @yield('footer')

    <!-- 基础JavaScript -->
    <script>
        // 移动端导航切换
        function toggleMobileNav() {
            const mobileNav = document.querySelector('.mobile-nav');
            mobileNav.classList.toggle('show');
        }

        // 点击页面其他地方关闭移动端菜单
        document.addEventListener('click', function(event) {
            const mobileNav = document.querySelector('.mobile-nav');
            const toggleBtn = document.querySelector('.mobile-nav-toggle');
            
            if (toggleBtn && mobileNav && !toggleBtn.contains(event.target) && !mobileNav.contains(event.target)) {
                mobileNav.classList.remove('show');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>