@extends('layouts.app')

@section('title', 'B站视频下载 - 哔哩哔哩视频解析 - 免费B站下载工具')
@section('description', '专业的B站视频下载工具，支持哔哩哔哩视频解析、高清视频下载、弹幕下载。免费在线B站下载器，支持4K、1080p等多种画质。')
@section('keywords', 'B站视频下载,哔哩哔哩下载,B站下载器,B站视频解析,bilibili下载,B站高清下载,B站弹幕下载')

@section('content')
<section class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-cyan-50 min-h-screen flex items-start justify-center pt-40">
    <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                <span class="bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">B站视频下载</span>
            </h1>
            <h2 class="text-xl md:text-2xl text-gray-600 mb-12 max-w-4xl mx-auto leading-relaxed">
                专业的哔哩哔哩视频下载工具，支持高清视频下载、弹幕保存、多P视频批量下载
            </h2>

            <!-- 解析框 -->
            <div class="max-w-4xl mx-auto mb-12">
                <form id="videoParseForm" class="relative">
                    @csrf
                    <div class="relative group input-container">
                        <input
                            type="text"
                            id="videoUrl"
                            name="video_url"
                            placeholder="粘贴B站视频链接到这里..."
                            class="w-full px-6 py-4 text-lg bg-white border-2 border-gray-200 focus:border-gray-300 focus:outline-none focus:ring-0 transition-all duration-300 shadow-lg hover:shadow-xl font-sleek"
                            required
                        >
                        <div class="absolute right-2 top-2 bottom-2 flex items-center gap-2">
                            <button type="button" id="pasteBtn" class="p-2 text-gray-500 hover:text-blue-600 transition-all duration-200 cursor-pointer hover:scale-110 flex-shrink-0" title="从剪贴板粘贴">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                </svg>
                            </button>
                            <button type="submit" class="parse-button bg-blue-600 hover:bg-blue-700 text-white transition-all duration-200 flex items-center justify-center cursor-pointer shadow-md hover:shadow-lg ui-text rounded-md px-3 py-2 flex-shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <span class="hidden sm:inline text-xs lg:text-sm font-medium ml-1 whitespace-nowrap">解析B站</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="hidden max-w-3xl mx-auto mb-8">
                <div class="bg-white border border-gray-100 rounded-2xl p-8 text-center shadow-xl">
                    <div class="flex items-center justify-center space-x-4 mb-4">
                        <div class="animate-spin rounded-full h-10 w-10 border-3 border-blue-600 border-t-transparent"></div>
                        <div class="animate-pulse h-3 bg-blue-200 rounded w-40"></div>
                    </div>
                    <p class="text-gray-600 font-medium text-lg body-regular">正在解析B站视频...</p>
                </div>
            </div>

            <!-- Parse Results -->
            <div id="parseResults" class="hidden max-w-6xl mx-auto"></div>
        </div>
    </div>
</section>

<!-- B站解析特色功能 -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl text-gray-900 mb-4">B站下载特色功能</h2>
            <p class="text-lg text-gray-600">专业的哔哩哔哩视频下载服务</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
            <div class="text-center group">
                <div class="w-20 h-20 bg-blue-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-blue-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V1a1 1 0 011-1h2a1 1 0 011 1v18a1 1 0 01-1 1H4a1 1 0 01-1-1V1a1 1 0 011-1h2a1 1 0 011 1v3"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4">多P视频下载</h3>
                <p class="text-gray-600 leading-relaxed">支持B站多P视频批量下载，一键获取整个视频系列</p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 bg-cyan-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-cyan-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4">弹幕文件下载</h3>
                <p class="text-gray-600 leading-relaxed">同时下载B站弹幕文件，支持ASS、SRT等字幕格式</p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 bg-indigo-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-indigo-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4">音频单独提取</h3>
                <p class="text-gray-600 leading-relaxed">从B站视频中提取高质量音频，支持多种音频格式</p>
            </div>
        </div>
    </div>
</section>

<!-- B站内容类型 -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl text-gray-900 mb-4">支持的B站内容类型</h2>
            <p class="text-lg text-gray-600">全面支持哔哩哔哩各种内容</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">普通视频</h3>
                <p class="text-sm text-gray-600">支持所有B站普通视频下载</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">番剧动漫</h3>
                <p class="text-sm text-gray-600">下载B站番剧和动漫内容</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">纪录片</h3>
                <p class="text-sm text-gray-600">高清纪录片内容下载</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">直播回放</h3>
                <p class="text-sm text-gray-600">B站直播回放内容保存</p>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pasteBtn = document.getElementById('pasteBtn');
    const videoInput = document.getElementById('videoUrl');

    if (pasteBtn && videoInput) {
        pasteBtn.addEventListener('click', async function() {
            try {
                const text = await navigator.clipboard.readText();
                videoInput.value = text;
                videoInput.focus();
            } catch (err) {
                console.log('Failed to read clipboard:', err);
            }
        });
    }
});
</script>
@endsection