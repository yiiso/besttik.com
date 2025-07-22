<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>运营管理后台</title>
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
                        <a href="{{ route('admin.dashboard') }}" class="bg-blue-100 text-blue-700 px-3 py-2 rounded-md text-sm font-medium">仪表板</a>
                        <a href="{{ route('admin.parse-logs') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">解析记录</a>
                        <a href="{{ route('admin.security') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">安全监控</a>
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
        <!-- 今日数据概览 -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-medium text-gray-900">今日数据概览</h2>
                <button onclick="showTodayHourlyData()" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    查看今日小时趋势
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow cursor-pointer" onclick="window.location.href='{{ route('admin.new-users') }}'">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">新增用户</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $todayData['new_users'] }}</dd>
                                    <dd class="text-xs text-blue-600">点击查看详细列表</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow cursor-pointer" onclick="window.location.href='{{ route('admin.parse-logs') }}'">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">解析总量</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $todayData['total_parses'] }}</dd>
                                    <dd class="text-xs text-blue-600">点击查看详情</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow cursor-pointer" onclick="window.location.href='{{ route('admin.parse-logs', ['status' => 'success']) }}'">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">解析成功</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $todayData['success_parses'] }}</dd>
                                    <dd class="text-xs text-blue-600">点击查看成功记录</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow cursor-pointer" onclick="window.location.href='{{ route('admin.parse-logs', ['status' => 'failed']) }}'">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">解析失败</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $todayData['failed_parses'] }}</dd>
                                    <dd class="text-xs text-blue-600">点击查看失败记录</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 数据趋势图 -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">数据趋势</h3>
                    
                    <!-- 快速选择按钮 -->
                    <div class="flex items-center space-x-2 mr-4">
                        <button type="button" onclick="quickSelect('yesterday')" 
                                class="px-3 py-1 text-xs bg-gray-100 text-gray-700 rounded hover:bg-gray-200 transition-colors">
                            昨天
                        </button>
                        <button type="button" onclick="quickSelect('today')" 
                                class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded hover:bg-green-200 transition-colors">
                            今天
                        </button>
                        <button type="button" onclick="quickSelect('7days')" 
                                class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition-colors">
                            最近7天
                        </button>
                        <button type="button" onclick="quickSelect('30days')" 
                                class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition-colors">
                            最近30天
                        </button>
                    </div>
                    
                    <!-- 简化的时间范围选择器 -->
                    <div class="flex items-center space-x-4">
                        <form method="GET" action="{{ route('admin.dashboard') }}" id="rangeForm" class="flex items-center space-x-2">
                            <select name="range" id="rangeSelect" onchange="handleRangeChange()" 
                                    class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                <option value="7days" {{ $dateRange === '7days' ? 'selected' : '' }}>最近7天</option>
                                <option value="30days" {{ $dateRange === '30days' ? 'selected' : '' }}>最近30天</option>
                                <option value="custom" {{ $dateRange === 'custom' ? 'selected' : '' }}>自定义范围</option>
                            </select>
                            
                            <!-- 自定义日期范围 -->
                            <div id="customDateRange" class="flex items-center space-x-2" style="display: {{ $dateRange === 'custom' ? 'flex' : 'none' }}">
                                <input type="date" name="start_date" value="{{ $startDate }}" 
                                       class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                <span class="text-gray-500">至</span>
                                <input type="date" name="end_date" value="{{ $endDate }}" 
                                       class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                                    查询
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- 图表容器 -->
                <div class="mb-6">
                    <canvas id="statsChart" width="400" height="200"></canvas>
                </div>

                <!-- 数据表格 -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50" id="statsTableHead">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" id="dateHeader">
                                    @php
                                        $isSingleDay = false;
                                        if ($dateRange === 'custom' && $startDate && $endDate) {
                                            $isSingleDay = \Carbon\Carbon::parse($startDate)->isSameDay(\Carbon\Carbon::parse($endDate));
                                        }
                                    @endphp
                                    {{ $isSingleDay ? '时间' : '日期' }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">新增用户</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">解析总量</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">解析成功</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">解析失败</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">成功率</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="statsTableBody">
                            @foreach($chartData as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    @if(isset($item['hour']))
                                        {{ $item['date'] }} {{ $item['date_display'] }}
                                    @else
                                        {{ $item['date'] }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['new_users'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item['total_parses'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">{{ $item['success_parses'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">{{ $item['failed_parses'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($item['total_parses'] > 0)
                                        {{ number_format(($item['success_parses'] / $item['total_parses']) * 100, 1) }}%
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // 北京时间辅助函数
        function getBeijingDate() {
            const now = new Date();
            const beijingTime = new Date(now.toLocaleString("en-US", {timeZone: "Asia/Shanghai"}));
            return beijingTime;
        }

        function getBeijingDateString() {
            const beijingDate = getBeijingDate();
            const year = beijingDate.getFullYear();
            const month = String(beijingDate.getMonth() + 1).padStart(2, '0');
            const day = String(beijingDate.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function getBeijingDateOffset(days) {
            const beijingDate = getBeijingDate();
            beijingDate.setDate(beijingDate.getDate() + days);
            const year = beijingDate.getFullYear();
            const month = String(beijingDate.getMonth() + 1).padStart(2, '0');
            const day = String(beijingDate.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // 图表数据
        const chartData = @json($chartData);
        const dateRange = @json($dateRange);
        
        // 检查是否为单天数据
        const isSingleDay = @json(isset($chartData[0]['hour']) ? true : false);
        
        // 创建图表
        const ctx = document.getElementById('statsChart').getContext('2d');
        let chart = new Chart(ctx, {
            type: isSingleDay ? 'bar' : 'line',
            data: {
                labels: chartData.map(day => day.date_display),
                datasets: [
                    {
                        label: '新增用户',
                        data: chartData.map(day => day.new_users),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: isSingleDay ? 'rgba(59, 130, 246, 0.8)' : 'rgba(59, 130, 246, 0.1)',
                        tension: isSingleDay ? undefined : 0.1,
                        borderWidth: isSingleDay ? 1 : 2
                    },
                    {
                        label: '解析总量',
                        data: chartData.map(day => day.total_parses),
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: isSingleDay ? 'rgba(16, 185, 129, 0.8)' : 'rgba(16, 185, 129, 0.1)',
                        tension: isSingleDay ? undefined : 0.1,
                        borderWidth: isSingleDay ? 1 : 2
                    },
                    {
                        label: '解析成功',
                        data: chartData.map(day => day.success_parses),
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: isSingleDay ? 'rgba(34, 197, 94, 0.8)' : 'rgba(34, 197, 94, 0.1)',
                        tension: isSingleDay ? undefined : 0.1,
                        borderWidth: isSingleDay ? 1 : 2
                    },
                    {
                        label: '解析失败',
                        data: chartData.map(day => day.failed_parses),
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: isSingleDay ? 'rgba(239, 68, 68, 0.8)' : 'rgba(239, 68, 68, 0.1)',
                        tension: isSingleDay ? undefined : 0.1,
                        borderWidth: isSingleDay ? 1 : 2
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: isSingleDay ? '今日24小时数据趋势' : getTitleByRange(dateRange)
                    },
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // 处理时间范围变化
        function handleRangeChange() {
            const rangeSelect = document.getElementById('rangeSelect');
            const customDateRange = document.getElementById('customDateRange');
            const rangeForm = document.getElementById('rangeForm');
            
            if (rangeSelect.value === 'custom') {
                customDateRange.style.display = 'flex';
            } else {
                customDateRange.style.display = 'none';
                // 自动提交表单
                rangeForm.submit();
            }
        }

        // 根据范围获取标题
        function getTitleByRange(range) {
            switch(range) {
                case '7days':
                    return '最近7天数据趋势';
                case '30days':
                    return '最近30天数据趋势';
                case 'custom':
                    return '自定义时间范围数据趋势';
                default:
                    return '数据趋势';
            }
        }

        // 异步更新图表数据
        async function updateChart(range, startDate = null, endDate = null) {
            try {
                const params = new URLSearchParams({ range });
                if (startDate) params.append('start_date', startDate);
                if (endDate) params.append('end_date', endDate);
                
                const response = await fetch(`{{ route('admin.api.stats') }}?${params}`);
                const result = await response.json();
                
                // 更新图表数据
                chart.data.labels = result.data.map(item => item.date_display);
                chart.data.datasets[0].data = result.data.map(item => item.new_users);
                chart.data.datasets[1].data = result.data.map(item => item.total_parses);
                chart.data.datasets[2].data = result.data.map(item => item.success_parses);
                chart.data.datasets[3].data = result.data.map(item => item.failed_parses);
                
                // 根据数据类型调整图表类型和样式
                if (result.is_single_day) {
                    // 切换到柱状图
                    chart.config.type = 'bar';
                    chart.options.plugins.title.text = '今日24小时数据趋势';
                    
                    // 为柱状图设置颜色和样式
                    const barColors = [
                        { bg: 'rgba(59, 130, 246, 0.8)', border: 'rgb(59, 130, 246)' },
                        { bg: 'rgba(16, 185, 129, 0.8)', border: 'rgb(16, 185, 129)' },
                        { bg: 'rgba(34, 197, 94, 0.8)', border: 'rgb(34, 197, 94)' },
                        { bg: 'rgba(239, 68, 68, 0.8)', border: 'rgb(239, 68, 68)' }
                    ];
                    
                    chart.data.datasets.forEach((dataset, index) => {
                        dataset.backgroundColor = barColors[index].bg;
                        dataset.borderColor = barColors[index].border;
                        dataset.borderWidth = 1;
                        delete dataset.tension;
                        delete dataset.fill;
                    });
                } else {
                    // 切换到折线图
                    chart.config.type = 'line';
                    chart.options.plugins.title.text = getTitleByRange(result.range);
                    
                    // 为折线图设置颜色和样式
                    const lineColors = [
                        { bg: 'rgba(59, 130, 246, 0.1)', border: 'rgb(59, 130, 246)' },
                        { bg: 'rgba(16, 185, 129, 0.1)', border: 'rgb(16, 185, 129)' },
                        { bg: 'rgba(34, 197, 94, 0.1)', border: 'rgb(34, 197, 94)' },
                        { bg: 'rgba(239, 68, 68, 0.1)', border: 'rgb(239, 68, 68)' }
                    ];
                    
                    chart.data.datasets.forEach((dataset, index) => {
                        dataset.backgroundColor = lineColors[index].bg;
                        dataset.borderColor = lineColors[index].border;
                        dataset.borderWidth = 2;
                        dataset.tension = 0.1;
                        dataset.fill = true;
                    });
                }
                
                // 确保图例显示
                chart.options.plugins.legend = {
                    display: true,
                    position: 'top'
                };
                
                // 更新表格
                updateTable(result.data, result.is_single_day);
                
                chart.update();
            } catch (error) {
                console.error('更新图表数据失败:', error);
            }
        }

        // 更新数据表格
        function updateTable(data, isSingleDay) {
            const tableBody = document.getElementById('statsTableBody');
            const dateHeader = document.getElementById('dateHeader');
            
            // 更新表头
            dateHeader.textContent = isSingleDay ? '时间' : '日期';
            
            // 清空表格内容
            tableBody.innerHTML = '';
            
            // 添加新数据
            data.forEach(item => {
                const row = document.createElement('tr');
                const successRate = item.total_parses > 0 ? 
                    ((item.success_parses / item.total_parses) * 100).toFixed(1) + '%' : '-';
                
                const dateDisplay = isSingleDay ? 
                    `${item.date} ${item.date_display}` : item.date;
                
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${dateDisplay}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.new_users}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.total_parses}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">${item.success_parses}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">${item.failed_parses}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${successRate}</td>
                `;
                tableBody.appendChild(row);
            });
        }

        // 显示今日小时数据
        async function showTodayHourlyData() {
            const today = getBeijingDateString();
            await updateChart('custom', today, today);
            
            // 更新URL参数
            const url = new URL(window.location);
            url.searchParams.set('range', 'custom');
            url.searchParams.set('start_date', today);
            url.searchParams.set('end_date', today);
            window.history.pushState({}, '', url);
            
            // 更新表单选择
            document.getElementById('rangeSelect').value = 'custom';
            document.querySelector('input[name="start_date"]').value = today;
            document.querySelector('input[name="end_date"]').value = today;
            document.getElementById('customDateRange').style.display = 'flex';
        }

        // 快速选择功能
        async function quickSelect(range) {
            let startDate, endDate;
            const today = getBeijingDateString();
            
            switch(range) {
                case 'yesterday':
                    const yesterday = getBeijingDateString(getBeijingDateOffset(-1));
                    startDate = endDate = yesterday;
                    break;
                case 'today':
                    startDate = endDate = today;
                    break;
                case '7days':
                    startDate = getBeijingDateString(getBeijingDateOffset(-6));
                    endDate = today;
                    break;
                case '30days':
                    startDate = getBeijingDateString(getBeijingDateOffset(-29));
                    endDate = today;
                    break;
                default:
                    return;
            }
            
            // 更新图表
            await updateChart('custom', startDate, endDate);
            
            // 更新表单
            document.getElementById('rangeSelect').value = 'custom';
            document.querySelector('input[name="start_date"]').value = startDate;
            document.querySelector('input[name="end_date"]').value = endDate;
            document.getElementById('customDateRange').style.display = 'flex';
            
            // 更新URL
            const url = new URL(window.location);
            url.searchParams.set('range', 'custom');
            url.searchParams.set('start_date', startDate);
            url.searchParams.set('end_date', endDate);
            window.history.pushState({}, '', url);
        }
    </script>

    <!-- 高级时间范围选择器 -->
    @include('admin.components.date-range-picker')
</body>
</html>