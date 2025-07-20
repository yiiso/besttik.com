@extends('layouts.app')

@section('title', __('messages.title'))
@section('description', __('messages.description'))
@section('keywords', __('messages.keywords'))

@section('content')
<!-- 消息提示 -->
@if(session('success'))
    <div class="fixed top-4 right-4 z-50 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg" id="flashMessage">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="fixed top-4 right-4 z-50 bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg" id="flashMessage">
        {{ session('error') }}
    </div>
@endif

@if(session('info'))
    <div class="fixed top-4 right-4 z-50 bg-blue-600 text-white px-6 py-3 rounded-lg shadow-lg" id="flashMessage">
        {{ session('info') }}
    </div>
@endif

@if(session('success') || session('error') || session('info'))
<script>
    // 自动隐藏消息提示
    document.addEventListener('DOMContentLoaded', function() {
        const flashMessage = document.getElementById('flashMessage');
        if (flashMessage) {
            // 5秒后自动隐藏
            setTimeout(() => {
                flashMessage.style.transform = 'translateX(100%)';
                flashMessage.style.opacity = '0';
                setTimeout(() => {
                    flashMessage.remove();
                }, 300);
            }, 5000);

            // 点击关闭
            flashMessage.style.cursor = 'pointer';
            flashMessage.addEventListener('click', function() {
                this.style.transform = 'translateX(100%)';
                this.style.opacity = '0';
                setTimeout(() => {
                    this.remove();
                }, 300);
            });
        }
    });
</script>
@endif

<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-gray-50 via-white to-blue-50 min-h-screen flex items-start justify-center pt-40">
    <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="text-center">
            <!-- Search Box - 主要操作区域 -->
            <div class="max-w-4xl mx-auto mb-12">
                <form id="videoParseForm" class="relative">
                    @csrf
                    <div class="relative group">
                        <input
                            type="text"
                            id="videoUrl"
                            name="video_url"
                            placeholder="{{ __('messages.paste_link') }}"
                            class="w-full px-6 py-4 text-lg bg-white border-2 border-gray-200  focus:border-gray-300 focus:outline-none focus:ring-0 transition-all duration-300 shadow-lg hover:shadow-xl pr-20 sm:pr-44 font-sleek"
                            required
                        >

                        <!-- 粘贴按钮 -->
                        <button
                            type="button"
                            id="pasteBtn"
                            class="absolute right-16 sm:right-32 top-1/2 transform -translate-y-1/2 p-1 sm:p-2 text-gray-500 hover:text-blue-600 transition-all duration-200 cursor-pointer hover:scale-110"
                            title="{{ __('messages.paste_from_clipboard') }}"
                        >
                            <!-- 更形象的粘贴图标 -->
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                            </svg>
                        </button>

                        <!-- 解析按钮 -->
                        <button
                            type="submit"
                            class="absolute right-2 top-2 bottom-2 px-3 sm:px-6 bg-blue-600 hover:bg-blue-700 text-white  transition-all duration-200 flex items-center space-x-2 cursor-pointer shadow-md hover:shadow-lg ui-text"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <span class="hidden sm:inline">{{ __('messages.parse') }}</span>
                        </button>
                    </div>
                </form>

                <!-- Parse Status Display -->
                <div id="parseStatus" class="mt-4 max-w-md mx-auto">
                    <!-- 解析状态将通过JavaScript动态更新 -->
                </div>

                <!-- Parse Warning -->
                <div id="parseWarning" class="hidden mt-4 max-w-md mx-auto">
                    <!-- 解析警告将通过JavaScript动态更新 -->
                </div>

                <!-- Quick Examples -->
                <div class="mt-8 flex flex-wrap justify-center gap-4 text-base">
                    <span class="text-gray-500 font-elegant">{{ __('messages.try_these') }}</span>
                    <button class="text-blue-600 hover:text-blue-700 underline transition-colors ui-text" onclick="document.getElementById('videoUrl').value='https://www.tiktok.com/@user/video/example'">TikTok</button>
                    <button class="text-blue-600 hover:text-blue-700 underline transition-colors ui-text" onclick="document.getElementById('videoUrl').value='https://www.youtube.com/watch?v=example'">YouTube</button>
                    <button class="text-blue-600 hover:text-blue-700 underline transition-colors ui-text" onclick="document.getElementById('videoUrl').value='https://x.com/yanbojack/status/exmaple_id'">twitter</button>
                    <button class="text-blue-600 hover:text-blue-700 underline transition-colors ui-text" onclick="document.getElementById('videoUrl').value='https://v.douyin.com/DfFwxy7M3LA/'">抖音</button>
                    <button class="text-blue-600 hover:text-blue-700 underline transition-colors ui-text" onclick="document.getElementById('videoUrl').value='https://www.facebook.com/watch/?v=1230685661697677'">facebook</button>
                    <button class="text-blue-600 hover:text-blue-700 underline transition-colors ui-text" onclick="document.getElementById('videoUrl').value='https://www.xiaohongshu.com/'">小红书</button>...
                </div>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="hidden max-w-3xl mx-auto mb-8">
                <div class="bg-white border border-gray-100 rounded-2xl p-8 text-center shadow-xl">
                    <div class="flex items-center justify-center space-x-4 mb-4">
                        <div class="animate-spin rounded-full h-10 w-10 border-3 border-blue-600 border-t-transparent"></div>
                        <div class="animate-pulse h-3 bg-blue-200 rounded w-40"></div>
                    </div>
                    <p class="text-gray-600 font-medium text-lg body-regular">{{ __('messages.parsing_video') }}</p>
                </div>
            </div>

            <!-- Parse Results -->
            <div id="parseResults" class="hidden max-w-6xl mx-auto">
                <!-- Results will be populated by JavaScript -->
            </div>
        </div>
    </div>
</section>

<!-- How to Use Section - SEO优化 -->
<section id="how-to-use" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl text-gray-900 mb-4 heading-elegant">{{ __('messages.how_to_use') }}</h2>
            <p class="text-lg text-gray-600 body-light">{{ __('messages.how_to_use_desc') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-blue-600">1</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.step_1_title') }}</h3>
                <p class="text-gray-600 text-sm">{{ __('messages.step_1_desc') }}</p>
            </div>

            <!-- Step 2 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-green-600">2</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.step_2_title') }}</h3>
                <p class="text-gray-600 text-sm">{{ __('messages.step_2_desc') }}</p>
            </div>

            <!-- Step 3 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-purple-600">3</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.step_3_title') }}</h3>
                <p class="text-gray-600 text-sm">{{ __('messages.step_3_desc') }}</p>
            </div>

            <!-- Step 4 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-orange-600">4</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.step_4_title') }}</h3>
                <p class="text-gray-600 text-sm">{{ __('messages.step_4_desc') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl text-gray-900 mb-4 heading-elegant">{{ __('messages.why_choose_us') }}</h2>
            <p class="text-lg text-gray-600 body-light">{{ __('messages.why_choose_desc') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
            <!-- Feature 1 -->
            <div class="text-center group">
                <div class="w-20 h-20 bg-blue-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-blue-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4 heading-modern">{{ __('messages.fast_parsing') }}</h3>
                <p class="text-gray-600 leading-relaxed body-light">
                    {{ __('messages.fast_parsing_desc') }}
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="text-center group">
                <div class="w-20 h-20 bg-green-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-green-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4 heading-modern">{{ __('messages.secure_reliable') }}</h3>
                <p class="text-gray-600 leading-relaxed body-light">
                    {{ __('messages.secure_reliable_desc') }}
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="text-center group">
                <div class="w-20 h-20 bg-purple-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-purple-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4 heading-modern">{{ __('messages.global_support') }}</h3>
                <p class="text-gray-600 leading-relaxed body-light">
                    {{ __('messages.global_support_desc') }}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Supported Platforms -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl text-gray-900 mb-4 heading-elegant">{{ __('messages.supported_platforms') }}</h2>
            <p class="text-lg text-gray-600 body-light">{{ __('messages.supported_platforms_desc') }}</p>
        </div>

        <div class="grid grid-cols-3 md:grid-cols-6 gap-8 lg:gap-12">
            <!-- YouTube -->
            <div class="flex flex-col items-center group cursor-pointer platform-card">
                <div class="w-16 h-16 bg-red-600 rounded-2xl flex items-center justify-center mb-4 shadow-soft">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                </div>
                <span class="text-gray-700 ui-text">YouTube</span>
            </div>

            <!-- TikTok -->
            <div class="flex flex-col items-center group cursor-pointer platform-card">
                <div class="w-16 h-16 bg-black rounded-2xl flex items-center justify-center mb-4 shadow-soft">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                    </svg>
                </div>
                <span class="text-gray-700 ui-text">TikTok</span>
            </div>

            <!-- Instagram -->
            <div class="flex flex-col items-center group cursor-pointer platform-card">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-pink-600 rounded-2xl flex items-center justify-center mb-4 shadow-soft">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </div>
                <span class="text-gray-700 ui-text">Instagram</span>
            </div>

            <!-- Facebook -->
            <div class="flex flex-col items-center group cursor-pointer platform-card">
                <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mb-4 shadow-soft">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </div>
                <span class="text-gray-700 ui-text">Facebook</span>
            </div>

            <!-- Twitter -->
            <div class="flex flex-col items-center group cursor-pointer platform-card">
                <div class="w-16 h-16 bg-blue-400 rounded-2xl flex items-center justify-center mb-4 shadow-soft">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                </div>
                <span class="text-gray-700 ui-text">Twitter</span>
            </div>

            <!-- More -->
            <div class="flex flex-col items-center group cursor-pointer platform-card">
                <div class="w-16 h-16 bg-gray-400 rounded-2xl flex items-center justify-center mb-4 shadow-soft">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <span class="text-gray-700 ui-text">{{ __('messages.more_platforms') }}</span>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
@include('components.faq-section')

<!-- CTA Section -->
<section class="py-20 bg-blue-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 heading-elegant">
            {{ __('messages.start_using') }}
        </h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto body-light">
            {{ __('messages.start_using_desc') }}
        </p>
        <a href="#" onclick="document.getElementById('videoUrl').focus()"
           class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200 ui-text">
            {{ __('messages.start_now') }}
            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
        </a>
    </div>
</section>
@endsection
