<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登录安全监控 - 运营管理后台</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        <a href="{{ route('admin.security') }}" class="bg-blue-100 text-blue-700 px-3 py-2 rounded-md text-sm font-medium">安全监控</a>
                        <a href="{{ route('admin.profile') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">个人资料</a>
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

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- 页面标题 -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">登录安全监控</h2>
            <p class="text-gray-600">监控管理员登录安全状况和异常尝试</p>
        </div>

        <!-- 今日统计概览 -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">今日失败尝试</dt>
                                <dd class="text-lg font-medium text-gray-900" id="totalAttempts">-</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">异常IP数量</dt>
                                <dd class="text-lg font-medium text-gray-900" id="uniqueIps">-</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 8A6 6 0 006.025.25 6 6 0 0018 8zm-13.5 9a4.5 4.5 0 117.5-4.5 4.5 4.5 0 01-7.5 4.5z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">涉及邮箱</dt>
                                <dd class="text-lg font-medium text-gray-900" id="uniqueEmails">-</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">最后更新</dt>
                                <dd class="text-sm font-medium text-gray-900" id="lastUpdate">-</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 24小时趋势图 -->
        <div class="bg-white shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">24小时失败尝试趋势</h3>
                <div class="mb-6">
                    <canvas id="hourlyChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- 紧急解锁工具 -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">紧急解锁工具</h3>
                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">注意</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>此工具仅在紧急情况下使用，用于解锁被误锁的管理员账户。</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <form id="unlockForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">邮箱地址</label>
                        <input type="email" id="unlockEmail" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">IP地址</label>
                        <input type="text" id="unlockIp" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            解锁账户
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let hourlyChart;
        
        // 加载统计数据
        async function loadStats() {
            try {
                const response = await fetch('{{ route("admin.login-stats") }}');
                const stats = await response.json();
                
                // 更新统计数字
                document.getElementById('totalAttempts').textContent = stats.total_attempts;
                document.getElementById('uniqueIps').textContent = stats.unique_ips;
                document.getElementById('uniqueEmails').textContent = stats.unique_emails;
                document.getElementById('lastUpdate').textContent = new Date().toLocaleString('zh-CN', {
                    timeZone: 'Asia/Shanghai',
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
                
                // 更新图表
                updateHourlyChart(stats.attempts_by_hour);
            } catch (error) {
                console.error('加载统计数据失败:', error);
            }
        }
        
        // 更新24小时趋势图
        function updateHourlyChart(data) {
            const ctx = document.getElementById('hourlyChart').getContext('2d');
            
            if (hourlyChart) {
                hourlyChart.destroy();
            }
            
            const hours = Array.from({length: 24}, (_, i) => i + ':00');
            
            hourlyChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: hours,
                    datasets: [{
                        label: '失败尝试次数',
                        data: data,
                        backgroundColor: 'rgba(239, 68, 68, 0.6)',
                        borderColor: 'rgba(239, 68, 68, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        title: {
                            display: true,
                            text: '今日各小时失败登录尝试分布'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }
        
        // 解锁账户
        document.getElementById('unlockForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const email = document.getElementById('unlockEmail').value;
            const ip = document.getElementById('unlockIp').value;
            
            if (!confirm(`确定要解锁邮箱 ${email} 和IP ${ip} 吗？`)) {
                return;
            }
            
            try {
                const response = await fetch('{{ route("admin.unlock") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ email, ip })
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    alert('解锁成功！');
                    document.getElementById('unlockForm').reset();
                } else {
                    alert('解锁失败：' + (result.message || '未知错误'));
                }
            } catch (error) {
                alert('解锁失败：网络错误');
                console.error('解锁失败:', error);
            }
        });
        
        // 页面加载时获取数据
        document.addEventListener('DOMContentLoaded', function() {
            loadStats();
            
            // 每30秒刷新一次数据
            setInterval(loadStats, 30000);
        });
    </script>
</body>
</html>