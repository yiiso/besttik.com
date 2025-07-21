<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>解析记录 - 运营管理后台</title>
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
                        <a href="{{ route('admin.parse-logs') }}" class="bg-blue-100 text-blue-700 px-3 py-2 rounded-md text-sm font-medium">解析记录</a>
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
        <!-- 页面标题和筛选 -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">解析记录</h2>
            
            <!-- 筛选表单 -->
            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <form method="GET" action="{{ route('admin.parse-logs') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">日期</label>
                        <input type="date" name="date" value="{{ request('date') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">状态</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">全部</option>
                            <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>成功</option>
                            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>失败</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">平台</label>
                        <select name="platform" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            筛选
                        </button>
                        <a href="{{ route('admin.parse-logs') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">
                            重置
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- 解析记录表格 -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
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
                                {{ $log->ip_address }}
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
    </div>
</body>
</html>