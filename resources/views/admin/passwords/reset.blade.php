<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>重置密码 - 管理员登录</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-6">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">重置密码</h1>
            <p class="text-gray-600 mt-2">请输入您的新密码</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.password.update') }}">
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">邮箱地址</label>
                <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" required readonly
                       class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">新密码</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <div class="mt-2">
                    <div class="flex items-center space-x-2 text-xs">
                        <div class="flex-1 bg-gray-200 rounded-full h-2">
                            <div id="strength-bar" class="h-2 rounded-full transition-all duration-300"></div>
                        </div>
                        <span id="strength-text" class="text-gray-500">密码强度</span>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1">密码至少8位，建议包含大小写字母、数字和特殊字符</p>
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">确认密码</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <div id="password-match" class="mt-1 text-xs hidden">
                    <span id="match-text"></span>
                </div>
            </div>

            <button type="submit" id="submit-btn" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 disabled:bg-gray-400 disabled:cursor-not-allowed">
                重置密码
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('admin.login') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                返回登录页面
            </a>
        </div>

        <!-- 密码要求说明 -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">密码要求</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul id="password-requirements" class="space-y-1">
                            <li id="req-length" class="flex items-center">
                                <span class="requirement-icon mr-2">○</span>
                                至少8个字符
                            </li>
                            <li id="req-lowercase" class="flex items-center">
                                <span class="requirement-icon mr-2">○</span>
                                包含小写字母
                            </li>
                            <li id="req-uppercase" class="flex items-center">
                                <span class="requirement-icon mr-2">○</span>
                                包含大写字母
                            </li>
                            <li id="req-number" class="flex items-center">
                                <span class="requirement-icon mr-2">○</span>
                                包含数字
                            </li>
                            <li id="req-special" class="flex items-center">
                                <span class="requirement-icon mr-2">○</span>
                                包含特殊字符
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const strengthBar = document.getElementById('strength-bar');
        const strengthText = document.getElementById('strength-text');
        const submitBtn = document.getElementById('submit-btn');
        const passwordMatch = document.getElementById('password-match');
        const matchText = document.getElementById('match-text');

        // 密码强度检查
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = checkPasswordStrength(password);
            updateStrengthDisplay(strength);
            updateRequirements(password);
            checkPasswordMatch();
        });

        confirmInput.addEventListener('input', checkPasswordMatch);

        function checkPasswordStrength(password) {
            let strength = 0;
            const checks = {
                length: password.length >= 8,
                lowercase: /[a-z]/.test(password),
                uppercase: /[A-Z]/.test(password),
                number: /[0-9]/.test(password),
                special: /[^A-Za-z0-9]/.test(password)
            };

            Object.values(checks).forEach(check => {
                if (check) strength++;
            });

            return { strength, checks };
        }

        function updateStrengthDisplay(result) {
            const { strength } = result;
            const colors = ['', '#ef4444', '#f97316', '#eab308', '#22c55e', '#16a34a'];
            const texts = ['', '很弱', '弱', '一般', '强', '很强'];
            
            strengthBar.style.width = `${(strength / 5) * 100}%`;
            strengthBar.style.backgroundColor = colors[strength];
            strengthText.textContent = texts[strength] || '密码强度';
            strengthText.style.color = colors[strength];
        }

        function updateRequirements(password) {
            const result = checkPasswordStrength(password);
            const requirements = {
                'req-length': result.checks.length,
                'req-lowercase': result.checks.lowercase,
                'req-uppercase': result.checks.uppercase,
                'req-number': result.checks.number,
                'req-special': result.checks.special
            };

            Object.entries(requirements).forEach(([id, met]) => {
                const element = document.getElementById(id);
                const icon = element.querySelector('.requirement-icon');
                
                if (met) {
                    element.classList.add('text-green-600');
                    element.classList.remove('text-blue-700');
                    icon.textContent = '✓';
                } else {
                    element.classList.remove('text-green-600');
                    element.classList.add('text-blue-700');
                    icon.textContent = '○';
                }
            });
        }

        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirm = confirmInput.value;
            
            if (confirm.length > 0) {
                passwordMatch.classList.remove('hidden');
                
                if (password === confirm) {
                    matchText.textContent = '✓ 密码匹配';
                    matchText.className = 'text-green-600';
                } else {
                    matchText.textContent = '✗ 密码不匹配';
                    matchText.className = 'text-red-600';
                }
            } else {
                passwordMatch.classList.add('hidden');
            }
            
            updateSubmitButton();
        }

        function updateSubmitButton() {
            const password = passwordInput.value;
            const confirm = confirmInput.value;
            const strength = checkPasswordStrength(password).strength;
            
            const isValid = password.length >= 8 && 
                           password === confirm && 
                           strength >= 3;
            
            submitBtn.disabled = !isValid;
        }
    </script>
</body>
</html>