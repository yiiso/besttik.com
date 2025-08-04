@extends('layouts.app')

@section('title', '微博视频解析 - 微博视频下载 - 免费微博视频保存工具')
@section('description', '专业的微博视频解析工具，支持微博视频下载、微博短视频保存、微博图片下载。免费在线微博解析器，高清视频下载。')
@section('keywords', '微博视频解析,微博视频下载,微博短视频下载,微博图片下载,微博解析工具,微博视频保存')

@section('content')
<section class="relative overflow-hidden bg-gradient-to-br from-red-50 via-white to-pink-50 min-h-screen flex items-start justify-center pt-40">
    <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                <span class="bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent">微博视频解析</span>
            </h1>
            <h2 class="text-xl md:text-2xl text-gray-600 mb-12 max-w-4xl mx-auto leading-relaxed">
                专业的微博内容解析工具，支持微博视频下载、图片保存、短视频提取
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
                            placeholder="粘贴微博链接到这里..."
                            class="w-full px-6 py-4 text-lg bg-white border-2 border-gray-200 focus:border-gray-300 focus:outline-none focus:ring-0 transition-all duration-300 shadow-lg hover:shadow-xl font-sleek"
                            required
                        >
                        <div class="absolute right-2 top-2 bottom-2 flex items-center gap-2">
                            <button type="button" id="pasteBtn" class="p-2 text-gray-500 hover:text-red-600 transition-all duration-200 cursor-pointer hover:scale-110 flex-shrink-0" title="从剪贴板粘贴">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                </svg>
                            </button>
                            <button type="submit" class="parse-button bg-red-600 hover:bg-red-700 text-white transition-all duration-200 flex items-center justify-center cursor-pointer shadow-md hover:shadow-lg ui-text rounded-md px-3 py-2 flex-shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <span class="hidden sm:inline text-xs lg:text-sm font-medium ml-1 whitespace-nowrap">解析微博</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="hidden max-w-3xl mx-auto mb-8">
                <div class="bg-white border border-gray-100 rounded-2xl p-8 text-center shadow-xl">
                    <div class="flex items-center justify-center space-x-4 mb-4">
                        <div class="animate-spin rounded-full h-10 w-10 border-3 border-red-600 border-t-transparent"></div>
                        <div class="animate-pulse h-3 bg-red-200 rounded w-40"></div>
                    </div>
                    <p class="text-gray-600 font-medium text-lg body-regular">正在解析微博内容...</p>
                </div>
            </div>

            <!-- Parse Results -->
            <div id="parseResults" class="hidden max-w-6xl mx-auto"></div>
        </div>
    </div>
</section>

<!-- 微博解析特色功能 -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl text-gray-900 mb-4">微博解析特色功能</h2>
            <p class="text-lg text-gray-600">专业的微博内容下载服务</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
            <div class="text-center group">
                <div class="w-20 h-20 bg-red-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-red-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4">视频下载</h3>
                <p class="text-gray-600 leading-relaxed">支持微博视频高清下载，保持原始画质</p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 bg-pink-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-pink-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4">图片保存</h3>
                <p class="text-gray-600 leading-relaxed">批量下载微博图片，支持高清原图保存</p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 bg-orange-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-orange-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4">快速解析</h3>
                <p class="text-gray-600 leading-relaxed">快速解析微博内容，支持多种格式下载</p>
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