@extends('layouts.admin')

@section('title', '新用户详细列表 - 运营管理后台')
@section('mobile-title', '新用户列表')

@section('content')
<!-- 页面标题和筛选 -->
<div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-3">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">新用户详细列表</h2>
        <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 text-sm w-full sm:w-auto text-center sm:text-left">
            ← 返回仪表板
        </a>
    </div>
    
    <!-- 筛选表单 -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <form method="GET" action="{{ route('admin.new-users') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">注册日期</label>
                <input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">搜索用户</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="姓名或邮箱"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>
            
            <div class="flex flex-col sm:flex-row sm:items-end gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm w-full sm:w-auto">
                    筛选
                </button>
                <a href="{{ route('admin.new-users') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 text-sm text-center w-full sm:w-auto">
                    重置
                </a>
            </div>
        </form>
    </div>

    <!-- 统计信息 -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <div class="text-sm text-gray-500">总用户数</div>
            <div class="text-xl sm:text-2xl font-bold text-gray-900">{{ $users->total() }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <div class="text-sm text-gray-500">已验证邮箱</div>
            <div class="text-xl sm:text-2xl font-bold text-green-600">
                {{ $users->where('email_verified_at', '!=', null)->count() }}
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <div class="text-sm text-gray-500">未验证邮箱</div>
            <div class="text-xl sm:text-2xl font-bold text-orange-600">
                {{ $users->where('email_verified_at', null)->count() }}
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow text-center">
            <div class="text-sm text-gray-500">Google注册</div>
            <div class="text-xl sm:text-2xl font-bold text-blue-600">
                {{ $users->where('google_id', '!=', null)->count() }}
            </div>
        </div>
    </div>
</div>

<!-- 用户列表 -->
<div class="bg-white shadow rounded-lg overflow-hidden">
    <!-- 桌面端表格 -->
    <div class="hidden lg:block overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">用户信息</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">注册时间</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">邮箱状态</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">注册方式</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">推荐信息</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">解析统计</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            @if($user->avatar)
                                <img class="h-10 w-10 rounded-full" src="{{ $user->avatar }}" alt="">
                            @else
                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-700">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ format_beijing_time($user->created_at, 'Y-m-d H:i:s') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->email_verified_at)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                已验证
                            </span>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ format_beijing_time($user->email_verified_at, 'm-d H:i') }}
                            </div>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                未验证
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if($user->google_id)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Google
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                邮箱注册
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <div>推荐码: <span class="font-mono">{{ $user->referral_code ?: '未生成' }}</span></div>
                        <div class="text-xs text-gray-500">
                            推荐人数: {{ $user->total_referrals }}
                            @if($user->bonus_parse_count > 0)
                                | 奖励次数: {{ $user->bonus_parse_count }}
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @php
                            $todayParses = \App\Models\ParseLog::where('user_id', $user->id)
                                ->whereDate('parse_date', \Carbon\Carbon::today())
                                ->count();
                            $totalParses = \App\Models\ParseLog::where('user_id', $user->id)->count();
                        @endphp
                        <div>今日: {{ $todayParses }}</div>
                        <div class="text-xs text-gray-500">总计: {{ $totalParses }}</div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        暂无用户数据
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- 移动端卡片视图 -->
    <div class="lg:hidden">
        @forelse($users as $user)
        <div class="border-b border-gray-200 p-4">
            <div class="flex items-start space-x-3 mb-3">
                @if($user->avatar)
                    <img class="h-12 w-12 rounded-full flex-shrink-0" src="{{ $user->avatar }}" alt="">
                @else
                    <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center flex-shrink-0">
                        <span class="text-sm font-medium text-gray-700">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</div>
                    <div class="text-xs text-gray-500 truncate">{{ $user->email }}</div>
                    <div class="text-xs text-gray-500 mt-1">
                        {{ format_beijing_time($user->created_at, 'Y-m-d H:i') }}
                    </div>
                </div>
                <div class="flex-shrink-0">
                    @if($user->email_verified_at)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            已验证
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                            未验证
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4 text-xs">
                <div>
                    <span class="text-gray-500">注册方式:</span>
                    @if($user->google_id)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 ml-1">
                            Google
                        </span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 ml-1">
                            邮箱
                        </span>
                    @endif
                </div>
                <div>
                    <span class="text-gray-500">推荐码:</span>
                    <span class="font-mono text-gray-900">{{ $user->referral_code ?: '未生成' }}</span>
                </div>
                <div>
                    <span class="text-gray-500">推荐人数:</span>
                    <span class="text-gray-900">{{ $user->total_referrals }}</span>
                </div>
                <div>
                    @php
                        $todayParses = \App\Models\ParseLog::where('user_id', $user->id)
                            ->whereDate('parse_date', \Carbon\Carbon::today())
                            ->count();
                        $totalParses = \App\Models\ParseLog::where('user_id', $user->id)->count();
                    @endphp
                    <span class="text-gray-500">解析:</span>
                    <span class="text-gray-900">今日{{ $todayParses }}/总{{ $totalParses }}</span>
                </div>
            </div>
        </div>
        @empty
        <div class="p-8 text-center text-gray-500">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
            </svg>
            <p>暂无用户数据</p>
        </div>
        @endforelse
    </div>
    
    <!-- 分页 -->
    @if($users->hasPages())
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        <div class="flex items-center justify-between">
            <div class="flex-1 flex justify-between sm:hidden">
                @if($users->previousPageUrl())
                    <a href="{{ $users->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        上一页
                    </a>
                @endif
                @if($users->nextPageUrl())
                    <a href="{{ $users->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        下一页
                    </a>
                @endif
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        显示第 <span class="font-medium">{{ $users->firstItem() }}</span> 到 <span class="font-medium">{{ $users->lastItem() }}</span> 条，
                        共 <span class="font-medium">{{ $users->total() }}</span> 条记录
                    </p>
                </div>
                <div>
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection