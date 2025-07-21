<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>个人资料 - 运营管理后台</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- 导航栏 -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <h1 class="text-xl font-semibold text-gray-900">运营管理后台</h1>
                    <nav class="flex space-x-4">
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">仪表板</a>
                        <a href="{{ route('admin.parse-logs') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">解析记录</a>
                        <a href="{{ route('admin.security') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">安全监控</a>
                        <a href="{{ route('admin.profile') }}" class="bg-blue-100 text-blue-700 px-3 py-2 rounded-md text-sm font-medium">个人资料</a>
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
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- 页面标题 -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">个人资料</h2>
            <p class="text-gray-600">管理您的账户信息和安全设置</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- 个人信息 -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">个人信息</h3>
                    <p class="text-sm text-gray-500">更新您的基本信息</p>
                </div>
                
                <form method="POST" action="{{ route('admin.profile.update') }}" class="px-6 py-4 space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">姓名</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $admin->name) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">邮箱地址</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $admin->email) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">账户状态</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $admin->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $admin->is_active ? '激活' : '禁用' }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">注册时间</label>
                        <p class="text-sm text-gray-900">{{ format_beijing_time($admin->created_at, 'Y-m-d H:i:s') }}</p>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            更新信息
                        </button>
                    </div>
                </form>
            </div>

            <!-- 修改密码 -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">修改密码</h3>
                    <p class="text-sm text-gray-500">确保您的账户安全</p>
                </div>
                
                <form method="POST" action="{{ route('admin.password.update') }}" class="px-6 py-4 space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">当前密码</label>
                        <input type="password" id="current_password" name="current_password" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('current_password') border-red-500 @enderror">
                        @error('current_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">新密码</label>
                        <input type="password" id="password" name="password" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">密码至少8位，包含大小写字母、数字和特殊字符</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">确认新密码</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            修改密码
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 安全提示 -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">安全提示</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li>定期更换密码以确保账户安全</li>
                            <li>不要在公共场所或不安全的网络环境下登录</li>
                            <li>如发现异常登录活动，请立即修改密码</li>
                            <li>妥善保管您的登录凭据，不要与他人分享</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // 密码强度检查
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;
            const strength = checkPasswordStrength(password);
            
            // 这里可以添加密码强度显示逻辑
        });

        function checkPasswordStrength(password) {
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            return strength;
        }
    </script>
</body>
</html>