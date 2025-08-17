@extends('layouts.app')

@section('title', __('messages.douyin_parser_title'))
@section('description', __('messages.douyin_parser_description'))
@section('keywords', __('messages.douyin_parser_keywords'))

@section('content')
<!-- 抖音专用解析页面 -->
<section class="relative overflow-hidden bg-gradient-to-br from-gray-50 via-white to-blue-50 min-h-screen flex items-start justify-center pt-40">
    <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="text-center">
            <!-- 抖音专用标题 -->
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">抖音视频解析</span>
            </h1>
            <h2 class="text-xl md:text-2xl text-gray-600 mb-12 max-w-4xl mx-auto leading-relaxed">
                专业的抖音视频在线解析工具，支持抖音去水印、抖音视频提取在线解析、抖音无水印下载
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
                            placeholder="粘贴抖音视频链接到这里..."
                            class="w-full px-6 py-4 text-lg bg-white border-2 border-gray-200 focus:border-gray-300 focus:outline-none focus:ring-0 transition-all duration-300 shadow-lg hover:shadow-xl font-sleek"
                            required
                        >

                        <!-- 按钮容器 -->
                        <div class="absolute right-2 top-2 bottom-2 flex items-center gap-2">
                            <!-- 粘贴按钮 -->
                            <button
                                type="button"
                                id="pasteBtn"
                                class="p-2 text-gray-500 hover:text-blue-600 transition-all duration-200 cursor-pointer hover:scale-110 flex-shrink-0"
                                title="从剪贴板粘贴"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                </svg>
                            </button>

                            <!-- 解析按钮 -->
                            <button
                                type="submit"
                                class="parse-button bg-blue-600 hover:bg-blue-700 text-white transition-all duration-200 flex items-center justify-center cursor-pointer shadow-md hover:shadow-lg ui-text rounded-md px-3 py-2 flex-shrink-0"
                            >
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <span class="hidden sm:inline text-xs lg:text-sm font-medium ml-1 whitespace-nowrap">解析抖音</span>
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
                    <p class="text-gray-600 font-medium text-lg body-regular">正在解析抖音视频...</p>
                </div>
            </div>

            <!-- Parse Results -->
            <div id="parseResults" class="hidden max-w-6xl mx-auto">
                <!-- Results will be populated by JavaScript -->
            </div>
        </div>
    </div>
</section>

<!-- 抖音解析特色功能 -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl text-gray-900 mb-4 heading-elegant">抖音视频解析特色功能</h2>
            <p class="text-lg text-gray-600 body-light">专业的抖音视频在线解析服务</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
            <!-- 去水印功能 -->
            <div class="text-center group">
                <div class="w-20 h-20 bg-blue-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-blue-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4 heading-modern">抖音去水印</h3>
                <p class="text-gray-600 leading-relaxed body-light">
                    自动去除抖音视频水印，获得干净清晰的视频文件，支持高清画质下载
                </p>
            </div>

            <!-- 在线解析 -->
            <div class="text-center group">
                <div class="w-20 h-20 bg-green-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-green-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4 heading-modern">抖音在线解析</h3>
                <p class="text-gray-600 leading-relaxed body-light">
                    无需下载软件，在线即可完成抖音视频解析，支持抖音视频提取在线解析
                </p>
            </div>

            <!-- 高清下载 -->
            <div class="text-center group">
                <div class="w-20 h-20 bg-purple-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-purple-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4 heading-modern">高清视频下载</h3>
                <p class="text-gray-600 leading-relaxed body-light">
                    保持原始画质，支持多种格式下载，满足不同设备播放需求
                </p>
            </div>
        </div>
    </div>
</section>

<!-- 抖音解析使用教程 -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl text-gray-900 mb-4 heading-elegant">抖音视频解析使用教程</h2>
            <p class="text-lg text-gray-600 body-light">简单4步完成抖音视频下载</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-blue-600">1</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">复制抖音链接</h3>
                <p class="text-gray-600 text-sm">在抖音APP中找到要下载的视频，点击分享按钮复制链接</p>
            </div>

            <!-- Step 2 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-green-600">2</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">粘贴到解析框</h3>
                <p class="text-gray-600 text-sm">将复制的抖音视频链接粘贴到上方的解析输入框中</p>
            </div>

            <!-- Step 3 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-purple-600">3</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">点击解析按钮</h3>
                <p class="text-gray-600 text-sm">点击"解析抖音"按钮，系统自动分析视频并去除水印</p>
            </div>

            <!-- Step 4 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-orange-600">4</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">下载视频</h3>
                <p class="text-gray-600 text-sm">选择合适的画质格式，点击下载按钮保存无水印视频</p>
            </div>
        </div>
    </div>
</section>

<!-- 常见问题 -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl text-gray-900 mb-4 heading-elegant">抖音解析常见问题</h2>
            <p class="text-lg text-gray-600 body-light">关于抖音视频解析的常见问题解答</p>
        </div>

        <div class="space-y-8">
            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">抖音视频解析是否免费？</h3>
                <p class="text-gray-600">是的，我们的抖音视频解析服务完全免费。游客用户每日有一定的解析次数限制，注册用户可获得更多解析机会。</p>
            </div>

            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">抖音去水印效果如何？</h3>
                <p class="text-gray-600">我们的抖音去水印技术能够完全去除抖音官方水印，保持视频原始画质，让您获得干净清晰的视频文件。</p>
            </div>

            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">支持哪些抖音视频格式？</h3>
                <p class="text-gray-600">支持所有抖音视频格式，包括短视频、长视频、直播回放等。输出格式支持MP4、WebM等主流格式。</p>
            </div>

            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">抖音视频解析速度如何？</h3>
                <p class="text-gray-600">我们采用先进的解析技术，通常在几秒钟内就能完成抖音视频解析，为您提供快速便捷的服务体验。</p>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 粘贴功能
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
