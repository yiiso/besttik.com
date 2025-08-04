@extends('layouts.app')

@section('title', 'YouTube视频下载 - YouTube视频解析 - 免费YouTube下载工具')
@section('description', '专业的YouTube视频下载工具，支持YouTube视频解析、高清视频下载、音频提取。免费在线YouTube下载器，支持4K、1080p等多种画质。')
@section('keywords', 'YouTube视频下载,YouTube下载器,YouTube视频解析,YouTube音频下载,YouTube高清下载,YouTube免费下载')

@section('content')
<section class="relative overflow-hidden bg-gradient-to-br from-red-50 via-white to-orange-50 min-h-screen flex items-start justify-center pt-40">
    <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                <span class="bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent">YouTube视频下载</span>
            </h1>
            <h2 class="text-xl md:text-2xl text-gray-600 mb-12 max-w-4xl mx-auto leading-relaxed">
                专业的YouTube视频下载工具，支持4K、1080p高清下载，音频提取，完全免费
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
                            placeholder="粘贴YouTube视频链接到这里..."
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
                                <span class="hidden sm:inline text-xs lg:text-sm font-medium ml-1 whitespace-nowrap">解析YouTube</span>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- YouTube示例链接 -->
                <div class="mt-8 flex flex-wrap justify-center gap-4 text-base">
                    <span class="text-gray-500 font-elegant">试试这些YouTube链接:</span>
                    <button class="text-red-600 hover:text-red-700 underline transition-colors ui-text" onclick="document.getElementById('videoUrl').value='https://www.youtube.com/watch?v=EwPJJy_YkHk'">音乐视频</button>
                    <button class="text-red-600 hover:text-red-700 underline transition-colors ui-text" onclick="document.getElementById('videoUrl').value='https://youtu.be/dQw4w9WgXcQ'">短链接</button>
                </div>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="hidden max-w-3xl mx-auto mb-8">
                <div class="bg-white border border-gray-100 rounded-2xl p-8 text-center shadow-xl">
                    <div class="flex items-center justify-center space-x-4 mb-4">
                        <div class="animate-spin rounded-full h-10 w-10 border-3 border-red-600 border-t-transparent"></div>
                        <div class="animate-pulse h-3 bg-red-200 rounded w-40"></div>
                    </div>
                    <p class="text-gray-600 font-medium text-lg body-regular">正在解析YouTube视频...</p>
                </div>
            </div>

            <!-- Parse Results -->
            <div id="parseResults" class="hidden max-w-6xl mx-auto"></div>
        </div>
    </div>
</section>

<!-- YouTube解析特色功能 -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl text-gray-900 mb-4">YouTube下载特色功能</h2>
            <p class="text-lg text-gray-600">专业的YouTube视频下载服务</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
            <div class="text-center group">
                <div class="w-20 h-20 bg-red-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-red-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V1a1 1 0 011-1h2a1 1 0 011 1v18a1 1 0 01-1 1H4a1 1 0 01-1-1V1a1 1 0 011-1h2a1 1 0 011 1v3"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4">4K超高清下载</h3>
                <p class="text-gray-600 leading-relaxed">支持4K、2K、1080p、720p等多种画质选择，保持原始视频质量</p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 bg-orange-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-orange-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 14.142M9 9a3 3 0 000 6h6a3 3 0 000-6H9z"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4">音频单独提取</h3>
                <p class="text-gray-600 leading-relaxed">支持从YouTube视频中提取高质量音频，支持MP3、AAC等格式</p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 bg-yellow-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-yellow-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4">极速下载</h3>
                <p class="text-gray-600 leading-relaxed">采用先进的下载技术，提供最快的YouTube视频下载速度</p>
            </div>
        </div>
    </div>
</section>

<!-- 支持格式 -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl text-gray-900 mb-4">支持的YouTube格式</h2>
            <p class="text-lg text-gray-600">多种格式和画质选择</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- 视频格式 -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    视频格式
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">MP4 (4K)</span>
                        <span class="text-sm text-gray-600">3840×2160</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">MP4 (1080p)</span>
                        <span class="text-sm text-gray-600">1920×1080</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">MP4 (720p)</span>
                        <span class="text-sm text-gray-600">1280×720</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">WebM</span>
                        <span class="text-sm text-gray-600">多种画质</span>
                    </div>
                </div>
            </div>

            <!-- 音频格式 -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 14.142M9 9a3 3 0 000 6h6a3 3 0 000-6H9z"/>
                    </svg>
                    音频格式
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">MP3</span>
                        <span class="text-sm text-gray-600">320kbps</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">AAC</span>
                        <span class="text-sm text-gray-600">256kbps</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">OGG</span>
                        <span class="text-sm text-gray-600">高质量</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">FLAC</span>
                        <span class="text-sm text-gray-600">无损音质</span>
                    </div>
                </div>
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