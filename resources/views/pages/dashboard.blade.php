@extends('layouts.app')

@section('title', __('messages.dashboard_title'))
@section('description', __('messages.dashboard_description'))

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- 页面标题 -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('messages.dashboard_title') }}</h1>
            <p class="mt-2 text-gray-600">{{ __('messages.dashboard_subtitle') }}</p>
        </div>

        <!-- 加载状态 -->
        <div id="loading" class="text-center py-8">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <p class="mt-2 text-gray-600">{{ __('messages.loading') }}</p>
        </div>

        <!-- 仪表板内容 -->
        <div id="dashboard-content" class="hidden">
            <!-- 用户信息卡片 -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h2 class="text-xl font-semibold text-gray-900" id="user-name"></h2>
                        <p class="text-gray-600" id="user-email"></p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">{{ __('messages.total_referrals') }}</p>
                        <p class="text-2xl font-bold text-blue-600" id="total-referrals">0</p>
                    </div>
                </div>
            </div>

            <!-- 解析统计卡片 -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">{{ __('messages.today_used') }}</p>
                            <p class="text-2xl font-semibold text-gray-900" id="today-used">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">{{ __('messages.remaining_today') }}</p>
                            <p class="text-2xl font-semibold text-gray-900" id="remaining-today">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">{{ __('messages.bonus_count') }}</p>
                            <p class="text-2xl font-semibold text-gray-900" id="bonus-count">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-orange-100 rounded-lg">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">{{ __('messages.total_limit') }}</p>
                            <p class="text-2xl font-semibold text-gray-900" id="total-limit">0</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 分享功能卡片 -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('messages.share_and_earn') }}</h3>
                <p class="text-gray-600 mb-4">{{ __('messages.share_description') }}</p>
                
                <div class="flex items-center space-x-4 mb-4">
                    <input type="text" id="referral-link" readonly 
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-sm">
                    <button onclick="copyReferralLink()" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        {{ __('messages.copy_link') }}
                    </button>
                    <button onclick="shareReferralLink()" 
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                        {{ __('messages.share') }}
                    </button>
                </div>

                <div class="text-sm text-gray-500">
                    <p>{{ __('messages.referral_code') }}: <span id="referral-code" class="font-mono font-semibold"></span></p>
                    <p>{{ __('messages.bonus_earned') }}: <span id="bonus-earned" class="font-semibold text-green-600"></span></p>
                </div>
            </div>

            <!-- 本周统计图表 -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('messages.weekly_stats') }}</h3>
                <div class="grid grid-cols-7 gap-2" id="weekly-chart">
                    <!-- 动态生成 -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadDashboardData();
});

async function loadDashboardData() {
    try {
        const response = await fetch('/api/dashboard');
        const data = await response.json();
        
        if (response.ok) {
            updateDashboard(data);
            document.getElementById('loading').classList.add('hidden');
            document.getElementById('dashboard-content').classList.remove('hidden');
        } else {
            throw new Error(data.error || 'Failed to load dashboard data');
        }
    } catch (error) {
        console.error('Error loading dashboard:', error);
        document.getElementById('loading').innerHTML = 
            '<p class="text-red-600">{{ __("messages.load_error") }}</p>';
    }
}

function updateDashboard(data) {
    // 更新用户信息
    document.getElementById('user-name').textContent = data.user.name;
    document.getElementById('user-email').textContent = data.user.email;
    document.getElementById('total-referrals').textContent = data.user.total_referrals;
    
    // 更新解析统计
    document.getElementById('today-used').textContent = data.parse_stats.today_used;
    document.getElementById('remaining-today').textContent = data.parse_stats.remaining_today;
    document.getElementById('bonus-count').textContent = data.parse_stats.bonus_parse_count;
    document.getElementById('total-limit').textContent = data.parse_stats.total_daily_limit;
    
    // 更新推荐信息
    document.getElementById('referral-link').value = data.referral.link;
    document.getElementById('referral-code').textContent = data.referral.code;
    document.getElementById('bonus-earned').textContent = data.referral.bonus_earned;
    
    // 更新本周统计
    updateWeeklyChart(data.weekly_stats);
}

function updateWeeklyChart(weeklyStats) {
    const chartContainer = document.getElementById('weekly-chart');
    chartContainer.innerHTML = '';
    
    weeklyStats.forEach(stat => {
        const dayElement = document.createElement('div');
        dayElement.className = 'text-center';
        
        const maxCount = Math.max(...weeklyStats.map(s => s.count));
        const height = maxCount > 0 ? Math.max(20, (stat.count / maxCount) * 100) : 20;
        
        dayElement.innerHTML = `
            <div class="bg-blue-200 rounded-t mb-1" style="height: ${height}px;"></div>
            <div class="text-xs font-medium text-gray-700">${stat.day}</div>
            <div class="text-xs text-gray-500">${stat.count}</div>
        `;
        
        chartContainer.appendChild(dayElement);
    });
}

function copyReferralLink() {
    const linkInput = document.getElementById('referral-link');
    linkInput.select();
    document.execCommand('copy');
    
    // 显示复制成功提示
    showNotification('{{ __("messages.link_copied") }}', 'success');
}

function shareReferralLink() {
    const link = document.getElementById('referral-link').value;
    
    if (navigator.share) {
        navigator.share({
            title: '{{ __("messages.share_title") }}',
            text: '{{ __("messages.share_text") }}',
            url: link
        });
    } else {
        copyReferralLink();
    }
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 px-4 py-2 rounded-md text-white z-50 ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 'bg-blue-500'
    }`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endsection