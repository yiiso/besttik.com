<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理员登录</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-6">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">管理员登录</h1>
            <p class="text-gray-600 mt-2">请输入您的管理员账号信息</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (isset($lockoutInfo))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded mb-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="font-medium">账户已被锁定</p>
                        <p class="text-sm">{{ $lockoutInfo['reason'] }}，请在 <span id="countdown">{{ $lockoutInfo['remaining_time'] }}</span> 秒后重试</p>
                        <p class="text-xs mt-1">锁定时间：{{ $lockoutInfo['locked_at'] }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (isset($attemptInfo) && ($attemptInfo['ip_attempts'] > 0 || $attemptInfo['email_attempts'] > 0))
            <div class="bg-orange-100 border border-orange-400 text-orange-800 px-4 py-3 rounded mb-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="font-medium">登录警告</p>
                        <p class="text-sm">您还可以尝试 {{ $attemptInfo['remaining_attempts'] }} 次，超过限制将被锁定15分钟</p>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">邮箱地址</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">密码</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">记住我</span>
                </label>
                <a href="{{ route('admin.password.request') }}" class="text-sm text-blue-600 hover:text-blue-800">
                    忘记密码？
                </a>
            </div>

            <button type="submit" id="loginBtn" 
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 disabled:bg-gray-400 disabled:cursor-not-allowed"
                    @if(isset($lockoutInfo)) disabled @endif>
                <span id="loginBtnText">
                    @if(isset($lockoutInfo))
                        账户已锁定
                    @else
                        登录
                    @endif
                </span>
            </button>
        </form>
    </div>

    @if(isset($lockoutInfo))
    <script>
        // 倒计时功能
        let remainingTime = {{ $lockoutInfo['remaining_time'] }};
        const countdownElement = document.getElementById('countdown');
        const loginBtn = document.getElementById('loginBtn');
        const loginBtnText = document.getElementById('loginBtnText');
        
        function updateCountdown() {
            if (remainingTime <= 0) {
                // 倒计时结束，刷新页面
                window.location.reload();
                return;
            }
            
            const minutes = Math.floor(remainingTime / 60);
            const seconds = remainingTime % 60;
            const timeStr = minutes > 0 ? `${minutes}分${seconds}秒` : `${seconds}秒`;
            
            countdownElement.textContent = timeStr;
            remainingTime--;
            
            setTimeout(updateCountdown, 1000);
        }
        
        // 开始倒计时
        updateCountdown();
    </script>
    @endif

    <script>
        // 防止表单重复提交
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('loginBtn');
            const btnText = document.getElementById('loginBtnText');
            
            if (submitBtn.disabled) {
                e.preventDefault();
                return false;
            }
            
            submitBtn.disabled = true;
            btnText.textContent = '登录中...';
            
            // 5秒后重新启用按钮（防止网络问题导致按钮永久禁用）
            setTimeout(() => {
                submitBtn.disabled = false;
                btnText.textContent = '登录';
            }, 5000);
        });
    </script>
</body>
</html>