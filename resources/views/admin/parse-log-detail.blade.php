@extends('layouts.admin')

@section('title', '解析记录详情 - 运营管理后台')
@section('mobile-title', '解析详情')

@section('content')
<!-- 返回按钮 -->
<div class="mb-6">
    <a href="{{ route('admin.parse-logs') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        返回解析记录列表
    </a>
</div>

<!-- 解析记录详情 -->
<div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-4 sm:px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">解析记录详情</h3>
        <p class="text-sm text-gray-500">记录ID: {{ $log->id }}</p>
    </div>

    <div class="px-4 sm:px-6 py-4 space-y-6">
        <!-- 基本信息 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <h4 class="text-sm font-medium text-gray-900 mb-3">基本信息</h4>
                <dl class="space-y-3">
                    <div class="flex flex-col sm:flex-row sm:justify-between">
                        <dt class="text-sm text-gray-500 mb-1 sm:mb-0">解析时间:</dt>
                        <dd class="text-sm text-gray-900">{{ format_beijing_time($log->created_at, 'Y-m-d H:i:s') }}</dd>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:justify-between">
                        <dt class="text-sm text-gray-500 mb-1 sm:mb-0">解析日期:</dt>
                        <dd class="text-sm text-gray-900">{{ format_beijing_time($log->parse_date, 'Y-m-d') }}</dd>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:justify-between">
                        <dt class="text-sm text-gray-500 mb-1 sm:mb-0">状态:</dt>
                        <dd class="text-sm">
                            @if($log->is_success)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    解析成功
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    解析失败
                                </span>
                            @endif
                        </dd>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:justify-between">
                        <dt class="text-sm text-gray-500 mb-1 sm:mb-0">平台:</dt>
                        <dd class="text-sm text-gray-900">
                            @if($log->platform)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ ucfirst($log->platform) }}
                                </span>
                            @else
                                <span class="text-gray-500">未识别</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>

            <div>
                <h4 class="text-sm font-medium text-gray-900 mb-3">用户信息</h4>
                <dl class="space-y-3">
                    @if($log->user)
                        <div class="flex flex-col sm:flex-row sm:justify-between">
                            <dt class="text-sm text-gray-500 mb-1 sm:mb-0">用户ID:</dt>
                            <dd class="text-sm text-gray-900">{{ $log->user->id }}</dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between">
                            <dt class="text-sm text-gray-500 mb-1 sm:mb-0">用户名:</dt>
                            <dd class="text-sm text-gray-900">{{ $log->user->name }}</dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between">
                            <dt class="text-sm text-gray-500 mb-1 sm:mb-0">邮箱:</dt>
                            <dd class="text-sm text-gray-900 break-all">{{ $log->user->email }}</dd>
                        </div>
                    @else
                        <div class="flex flex-col sm:flex-row sm:justify-between">
                            <dt class="text-sm text-gray-500 mb-1 sm:mb-0">用户类型:</dt>
                            <dd class="text-sm text-gray-500">游客用户</dd>
                        </div>
                    @endif
                    <div class="flex flex-col sm:flex-row sm:justify-between">
                        <dt class="text-sm text-gray-500 mb-1 sm:mb-0">IP地址:</dt>
                        <dd class="text-sm text-gray-900 font-mono">{{ $log->ip_address }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- 视频URL -->
        <div>
            <h4 class="text-sm font-medium text-gray-900 mb-3">视频链接</h4>
            <div class="bg-gray-50 p-3 rounded-md">
                <p class="text-sm text-gray-900 break-all">{{ $log->video_url }}</p>
                @if($log->video_url)
                    <a href="{{ $log->video_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm mt-2 inline-block">
                        在新窗口中打开 ↗
                    </a>
                @endif
            </div>
        </div>

        <!-- User Agent -->
        @if($log->user_agent)
        <div>
            <h4 class="text-sm font-medium text-gray-900 mb-3">用户代理</h4>
            <div class="bg-gray-50 p-3 rounded-md">
                <p class="text-sm text-gray-700 break-all">{{ $log->user_agent }}</p>
            </div>
        </div>
        @endif

        <!-- 错误信息 -->
        @if(!$log->is_success && $log->error_message)
        <div>
            <h4 class="text-sm font-medium text-gray-900 mb-3">错误信息</h4>
            <div class="bg-red-50 border border-red-200 p-3 rounded-md">
                <p class="text-sm text-red-800 break-words">{{ $log->error_message }}</p>
            </div>
        </div>
        @endif

        <!-- 解析结果 -->
        @if($log->is_success && $log->parse_result)
        <div>
            <h4 class="text-sm font-medium text-gray-900 mb-3">解析结果</h4>
            <div class="bg-green-50 border border-green-200 p-3 rounded-md">
                <pre class="text-sm text-green-800 whitespace-pre-wrap overflow-x-auto">{{ json_encode($log->parse_result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        </div>
        @endif
    </div>

    <!-- 操作按钮 -->
    <div class="px-4 sm:px-6 py-4 bg-gray-50 border-t border-gray-200">
        <div class="flex flex-col sm:flex-row sm:justify-between gap-3">
            <a href="{{ route('admin.parse-logs') }}" 
               class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 text-center text-sm">
                返回列表
            </a>
            
            @if($log->is_success && $log->parse_result)
            <button onclick="copyResult()" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                复制解析结果
            </button>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyResult() {
    const result = @json($log->parse_result ?? '');
    const text = JSON.stringify(result, null, 2);
    
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            showToast('解析结果已复制到剪贴板', 'success');
        }).catch(() => {
            fallbackCopy(text);
        });
    } else {
        fallbackCopy(text);
    }
}

function fallbackCopy(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-999999px';
    textArea.style.top = '-999999px';
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        document.execCommand('copy');
        showToast('解析结果已复制到剪贴板', 'success');
    } catch (err) {
        showToast('复制失败，请手动复制', 'error');
    }
    
    document.body.removeChild(textArea);
}

function showToast(message, type = 'info') {
    // 创建toast元素
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-4 py-2 rounded-md text-white text-sm transition-opacity duration-300 ${
        type === 'success' ? 'bg-green-600' : 
        type === 'error' ? 'bg-red-600' : 'bg-blue-600'
    }`;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    // 3秒后移除
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}
</script>
@endpush