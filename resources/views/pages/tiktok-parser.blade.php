@extends('layouts.app')

@section('title', 'TikTok视频下载 - TikTok去水印 - 免费TikTok视频解析工具')
@section('description', '专业的TikTok视频下载工具，支持TikTok去水印、TikTok视频解析、TikTok无水印下载。免费在线TikTok下载器，高清视频下载，支持批量下载TikTok视频。')
@section('keywords', 'TikTok视频下载,TikTok去水印,TikTok视频解析,TikTok下载器,TikTok无水印下载,TikTok视频保存,TikTok解析工具')

@section('content')
<section class="relative overflow-hidden bg-gradient-to-br from-black via-gray-900 to-purple-900 min-h-screen flex items-start justify-center pt-40">
    <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                <span class="bg-gradient-to-r from-pink-400 to-purple-400 bg-clip-text text-transparent">TikTok视频下载</span>
            </h1>
            <h2 class="text-xl md:text-2xl text-gray-300 mb-12 max-w-4xl mx-auto leading-relaxed">
                专业的TikTok视频下载工具，支持TikTok去水印、TikTok视频解析、TikTok无水印下载，完全免费
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
                            placeholder="粘贴TikTok视频链接到这里..."
                            class="w-full px-6 py-4 text-lg bg-white border-2 border-gray-200 focus:border-pink-400 focus:outline-none focus:ring-0 transition-all duration-300 shadow-lg hover:shadow-xl font-sleek rounded-xl"
                            required
                        >
                        <div class="absolute right-2 top-2 bottom-2 flex items-center gap-2">
                            <button type="button" id="pasteBtn" class="p-2 text-gray-500 hover:text-pink-600 transition-all duration-200 cursor-pointer hover:scale-110 flex-shrink-0" title="从剪贴板粘贴">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                </svg>
                            </button>
                            <button type="submit" class="parse-button bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-700 hover:to-purple-700 text-white transition-all duration-200 flex items-center justify-center cursor-pointer shadow-md hover:shadow-lg ui-text rounded-xl px-4 py-2 flex-shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <span class="hidden sm:inline text-xs lg:text-sm font-medium ml-1 whitespace-nowrap">解析TikTok</span>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- TikTok示例链接 -->
                <div class="mt-8 flex flex-wrap justify-center gap-4 text-base">
                    <span class="text-gray-400 font-elegant">试试这些TikTok链接:</span>
                    <button class="text-pink-400 hover:text-pink-300 underline transition-colors ui-text" onclick="document.getElementById('videoUrl').value='https://www.tiktok.com/@username/video/1234567890'">TikTok短视频</button>
                    <button class="text-purple-400 hover:text-purple-300 underline transition-colors ui-text" onclick="document.getElementById('videoUrl').value='https://vm.tiktok.com/ZMd1234567/'">TikTok分享链接</button>
                </div>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="hidden max-w-3xl mx-auto mb-8">
                <div class="bg-gray-800 border border-gray-700 rounded-2xl p-8 text-center shadow-xl">
                    <div class="flex items-center justify-center space-x-4 mb-4">
                        <div class="animate-spin rounded-full h-10 w-10 border-3 border-pink-600 border-t-transparent"></div>
                        <div class="animate-pulse h-3 bg-pink-200 rounded w-40"></div>
                    </div>
                    <p class="text-gray-300 font-medium text-lg body-regular">正在解析TikTok视频...</p>
                </div>
            </div>

            <!-- Parse Results -->
            <div id="parseResults" class="hidden max-w-6xl mx-auto"></div>
        </div>
    </div>
</section>

<!-- TikTok解析特色功能 -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl text-gray-900 mb-4">TikTok下载特色功能</h2>
            <p class="text-lg text-gray-600">专业的TikTok视频下载服务</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
            <div class="text-center group">
                <div class="w-20 h-20 bg-pink-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-pink-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4">TikTok去水印</h3>
                <p class="text-gray-600 leading-relaxed">自动去除TikTok视频水印，获得干净清晰的TikTok视频文件，支持高清画质TikTok下载</p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 bg-purple-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-purple-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4">TikTok快速解析</h3>
                <p class="text-gray-600 leading-relaxed">无需下载软件，在线即可完成TikTok视频解析，支持TikTok视频批量下载</p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 bg-indigo-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-indigo-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4">TikTok高清下载</h3>
                <p class="text-gray-600 leading-relaxed">保持TikTok原始画质，支持多种格式TikTok视频下载，满足不同设备播放需求</p>
            </div>
        </div>
    </div>
</section>

<!-- TikTok使用教程 -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl text-gray-900 mb-4">TikTok视频下载使用教程</h2>
            <p class="text-lg text-gray-600">简单4步完成TikTok视频下载</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-pink-600">1</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">复制TikTok链接</h3>
                <p class="text-gray-600 text-sm">在TikTok APP中找到要下载的视频，点击分享按钮复制TikTok视频链接</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-purple-600">2</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">粘贴到TikTok解析框</h3>
                <p class="text-gray-600 text-sm">将复制的TikTok视频链接粘贴到上方的TikTok解析输入框中</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-indigo-600">3</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">点击TikTok解析按钮</h3>
                <p class="text-gray-600 text-sm">点击"解析TikTok"按钮，系统自动分析TikTok视频并去除水印</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-blue-600">4</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">下载TikTok视频</h3>
                <p class="text-gray-600 text-sm">选择合适的画质格式，点击下载按钮保存TikTok无水印视频</p>
            </div>
        </div>
    </div>
</section>

<!-- TikTok常见问题 -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl text-gray-900 mb-4">TikTok下载常见问题</h2>
            <p class="text-lg text-gray-600">关于TikTok视频下载的常见问题解答</p>
        </div>

        <div class="space-y-8">
            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">TikTok视频下载是否免费？</h3>
                <p class="text-gray-600">是的，我们的TikTok视频下载服务完全免费。游客用户每日有一定的TikTok解析次数限制，注册用户可获得更多TikTok下载机会。</p>
            </div>

            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">TikTok去水印效果如何？</h3>
                <p class="text-gray-600">我们的TikTok去水印技术能够完全去除TikTok官方水印，保持TikTok视频原始画质，让您获得干净清晰的TikTok视频文件。</p>
            </div>

            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">支持哪些TikTok视频格式？</h3>
                <p class="text-gray-600">支持所有TikTok视频格式，包括TikTok短视频、TikTok长视频等。输出格式支持MP4、WebM等主流格式，确保TikTok视频下载兼容性。</p>
            </div>

            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">TikTok视频下载速度如何？</h3>
                <p class="text-gray-600">我们采用先进的TikTok解析技术，通常在几秒钟内就能完成TikTok视频解析，为您提供快速便捷的TikTok下载服务体验。</p>
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