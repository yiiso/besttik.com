@extends('layouts.admin')

@section('title', '解析记录 - 运营管理后台')
@section('mobile-title', '解析记录')

@section('content')
<!-- 页面标题和筛选 -->
<div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-3">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">解析记录</h2>
        <button onclick="showIpStats()" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm w-full sm:w-auto">
            查看IP统计
        </button>
    </div>
    
    <!-- 筛选表单 -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <form method="GET" action="{{ route('admin.parse-logs') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">日期</label>
                <input type="date" name="date" value="{{ request('date') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">状态</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    <option value="">全部</option>
                    <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>成功</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>失败</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">平台</label>
                <select name="platform" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    <option value="">全部平台</option>
                    @foreach($platforms as $platform)
                        <option value="{{ $platform }}" {{ request('platform') === $platform ? 'selected' : '' }}>
                            {{ ucfirst($platform) }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">IP地址</label>
                <input type="text" name="ip" value="{{ request('ip') }}" placeholder="输入IP地址"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            
            <div class="flex flex-col sm:flex-row sm:items-end gap-2 lg:col-span-1">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm w-full sm:w-auto">
                    筛选
                </button>
                <a href="{{ route('admin.parse-logs') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 text-sm text-center w-full sm:w-auto">
                    重置
                </a>
            </div>
        </form>
    </div>
</div>

<!-- 解析记录表格 -->
<div class="bg-white shadow rounded-lg overflow-hidden">
    <!-- 桌面端表格 -->
    <div class="hidden md:block overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">时间</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">用户</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP地址</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">平台</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">视频URL</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">状态</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">操作</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($logs as $log)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ format_beijing_time($log->created_at, 'Y-m-d H:i:s') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if($log->user)
                            <div>
                                <div class="font-medium">{{ $log->user->name }}</div>
                                <div class="text-gray-500">{{ $log->user->email }}</div>
                            </div>
                        @else
                            <span class="text-gray-500">游客</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div>{{ $log->ip_address }}</div>
                        <div class="text-xs text-gray-500" id="location-{{ $log->id }}">
                            加载位置信息...
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if($log->platform)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst($log->platform) }}
                            </span>
                        @else
                            <span class="text-gray-500">未知</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 max-w-xs">
                        <div class="truncate" title="{{ $log->video_url }}">
                            {{ $log->video_url }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($log->is_success)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                成功
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                失败
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.parse-log-detail', $log->id) }}" 
                           class="text-blue-600 hover:text-blue-900">查看详情</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        暂无解析记录
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- 移动端卡片视图 -->
    <div class="md:hidden">
        @forelse($logs as $log)
        <div class="border-b border-gray-200 p-4">
            <div class="flex justify-between items-start mb-3">
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium text-gray-900 truncate">
                        @if($log->user)
                            {{ $log->user->name }}
                        @else
                            游客
                        @endif
                    </div>
                    <div class="text-xs text-gray-500 mt-1">
                        {{ format_beijing_time($log->created_at, 'Y-m-d H:i:s') }}
                    </div>
                </div>
                <div class="flex-shrink-0 ml-2">
                    @if($log->is_success)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            成功
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            失败
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="space-y-2">
                <div class="flex justify-between text-xs">
                    <span class="text-gray-500">IP地址:</span>
                    <span class="text-gray-900 font-mono">{{ $log->ip_address }}</span>
                </div>
                
                @if($log->platform)
                <div class="flex justify-between text-xs">
                    <span class="text-gray-500">平台:</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                        {{ ucfirst($log->platform) }}
                    </span>
                </div>
                @endif
                
                <div class="text-xs">
                    <div class="text-gray-500 mb-1">视频URL:</div>
                    <div class="text-gray-900 break-all text-xs">{{ $log->video_url }}</div>
                </div>
                
                <div class="pt-2 border-t border-gray-100">
                    <a href="{{ route('admin.parse-log-detail', $log->id) }}" 
                       class="text-blue-600 hover:text-blue-900 text-xs font-medium">查看详情 →</a>
                </div>
            </div>
        </div>
        @empty
        <div class="p-8 text-center text-gray-500">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p>暂无解析记录</p>
        </div>
        @endforelse
    </div>
    
    <!-- 分页 -->
    @if($logs->hasPages())
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        <div class="flex items-center justify-between">
            <div class="flex-1 flex justify-between sm:hidden">
                @if($logs->previousPageUrl())
                    <a href="{{ $logs->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        上一页
                    </a>
                @endif
                @if($logs->nextPageUrl())
                    <a href="{{ $logs->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        下一页
                    </a>
                @endif
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        显示第 <span class="font-medium">{{ $logs->firstItem() }}</span> 到 <span class="font-medium">{{ $logs->lastItem() }}</span> 条，
                        共 <span class="font-medium">{{ $logs->total() }}</span> 条记录
                    </p>
                </div>
                <div>
                    {{ $logs->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- IP统计模态框 -->
<div id="ipStatsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-4 sm:top-20 mx-auto p-4 sm:p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white m-4">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">IP地址统计</h3>
                <button onclick="hideIpStats()" class="text-gray-400 hover:text-gray-600 p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- 时间范围选择 -->
            <div class="mb-4">
                <div class="flex flex-wrap gap-2">
                    <button onclick="loadIpStats('today')" class="px-3 py-2 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200 flex-1 sm:flex-none">今天</button>
                    <button onclick="loadIpStats('7days')" class="px-3 py-2 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200 flex-1 sm:flex-none">最近7天</button>
                    <button onclick="loadIpStats('30days')" class="px-3 py-2 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200 flex-1 sm:flex-none">最近30天</button>
                </div>
            </div>

            <!-- 统计信息 -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                <div class="bg-gray-50 p-3 rounded text-center">
                    <div class="text-sm text-gray-500">独立IP数量</div>
                    <div class="text-xl font-bold" id="uniqueIpCount">-</div>
                </div>
                <div class="bg-gray-50 p-3 rounded text-center">
                    <div class="text-sm text-gray-500">总请求数</div>
                    <div class="text-xl font-bold" id="totalRequests">-</div>
                </div>
                <div class="bg-gray-50 p-3 rounded text-center">
                    <div class="text-sm text-gray-500">平均请求/IP</div>
                    <div class="text-xl font-bold" id="avgRequests">-</div>
                </div>
            </div>

            <!-- IP列表 -->
            <div class="max-h-96 overflow-y-auto">
                <!-- 桌面端表格 -->
                <div class="hidden sm:block">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP地址</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">位置</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">请求次数</th>
                            </tr>
                        </thead>
                        <tbody id="ipStatsTableBody" class="bg-white divide-y divide-gray-200">
                            <!-- 动态加载 -->
                        </tbody>
                    </table>
                </div>
                
                <!-- 移动端列表 -->
                <div class="sm:hidden" id="ipStatsMobileList">
                    <!-- 动态加载 -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// 显示IP统计
function showIpStats() {
    document.getElementById('ipStatsModal').classList.remove('hidden');
    loadIpStats('today');
}

// 隐藏IP统计
function hideIpStats() {
    document.getElementById('ipStatsModal').classList.add('hidden');
}

// 加载IP统计数据
async function loadIpStats(range) {
    try {
        const response = await fetch(`{{ route('admin.ip-stats') }}?range=${range}`);
        const data = await response.json();
        
        // 更新统计数字
        document.getElementById('uniqueIpCount').textContent = data.total_unique_ips;
        document.getElementById('totalRequests').textContent = data.total_requests;
        document.getElementById('avgRequests').textContent = data.total_unique_ips > 0 ? 
            Math.round(data.total_requests / data.total_unique_ips * 10) / 10 : 0;
        
        // 更新桌面端表格
        const tbody = document.getElementById('ipStatsTableBody');
        if (tbody) {
            tbody.innerHTML = '';
            
            data.ip_stats.forEach(item => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">${item.ip_address}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.location_text}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.count}</td>
                `;
                tbody.appendChild(row);
            });
        }
        
        // 更新移动端列表
        const mobileList = document.getElementById('ipStatsMobileList');
        if (mobileList) {
            mobileList.innerHTML = '';
            
            data.ip_stats.forEach(item => {
                const card = document.createElement('div');
                card.className = 'border-b border-gray-200 p-3';
                card.innerHTML = `
                    <div class="flex justify-between items-center">
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-mono text-gray-900">${item.ip_address}</div>
                            <div class="text-xs text-gray-500 mt-1">${item.location_text}</div>
                        </div>
                        <div class="flex-shrink-0 ml-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                ${item.count} 次
                            </span>
                        </div>
                    </div>
                `;
                mobileList.appendChild(card);
            });
        }
    } catch (error) {
        console.error('加载IP统计失败:', error);
    }
}

// 页面加载时获取IP位置信息
document.addEventListener('DOMContentLoaded', function() {
    const ipElements = document.querySelectorAll('[id^="location-"]');
    const ips = Array.from(ipElements).map(el => {
        const logId = el.id.replace('location-', '');
        const ipAddress = el.closest('tr').querySelector('td:nth-child(3) div:first-child').textContent;
        return { element: el, ip: ipAddress };
    });

    // 批量获取IP位置信息
    if (ips.length > 0) {
        fetch('{{ route("admin.batch-ip-location") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                ips: ips.map(item => item.ip)
            })
        })
        .then(response => response.json())
        .then(data => {
            ips.forEach(item => {
                const location = data[item.ip];
                if (location) {
                    item.element.textContent = location.location_text || '未知位置';
                } else {
                    item.element.textContent = '未知位置';
                }
            });
        })
        .catch(error => {
            console.error('获取IP位置信息失败:', error);
            ips.forEach(item => {
                item.element.textContent = '获取失败';
            });
        });
    }
});
</script>
@endpush