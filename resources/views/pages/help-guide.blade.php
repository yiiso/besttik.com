@extends('layouts.app')

@section('title', __('messages.help_guide_title'))
@section('description', __('messages.help_guide_description'))
@section('keywords', __('messages.help_guide_keywords'))

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- 页面标题 -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ __('messages.help_guide_heading') }}</h1>
            <p class="text-xl text-gray-600">{{ __('messages.help_guide_subheading') }}</p>
        </div>

        <!-- 快速开始 -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                {{ __('messages.quick_start') }}
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-lg font-bold text-blue-600">1</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('messages.copy_video_link') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('messages.copy_video_link_desc') }}</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-lg font-bold text-green-600">2</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('messages.paste_into_input') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('messages.paste_into_input_desc') }}</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-lg font-bold text-purple-600">3</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('messages.click_parse') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('messages.click_parse_desc') }}</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-lg font-bold text-orange-600">4</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('messages.download_video') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('messages.click_download') }}</p>
                </div>
            </div>
        </div>

        <!-- 支持平台 -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ __('messages.supported_platforms') }}
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                <!-- <div class="flex items-center p-3 bg-gray-50 rounded-lg"><span class="font-medium text-gray-900">YouTube</span></div> 已移除 -->
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <span class="font-medium text-gray-900">{{ __('messages.platform_tiktok') }}</span>
                </div>
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <span class="font-medium text-gray-900">{{ __('messages.platform_instagram') }}</span>
                </div>
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <span class="font-medium text-gray-900">{{ __('messages.platform_facebook') }}</span>
                </div>
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <span class="font-medium text-gray-900">{{ __('messages.platform_twitter') }}</span>
                </div>
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <span class="font-medium text-gray-900">{{ __('messages.platform_snapchat') }}</span>
                </div>
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <span class="font-medium text-gray-900">{{ __('messages.platform_pinterest') }}</span>
                </div>

            </div>
        </div>

        <!-- 常见问题 -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ __('messages.common_issues') }}
            </h2>
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.is_service_free') }}</h3>
                    <p class="text-gray-600">{{ __('messages.is_service_free_desc') }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.supported_video_formats') }}</h3>
                    <p class="text-gray-600">{{ __('messages.supported_video_formats_desc') }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.download_failed') }}</h3>
                    <p class="text-gray-600">{{ __('messages.download_failed_answer') }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.batch_download_help') }}</h3>
                    <p class="text-gray-600">{{ __('messages.batch_download_help_answer') }}</p>
                </div>
            </div>
        </div>

        <!-- 联系支持 -->
        <div class="text-center mt-12">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ __('messages.need_more_help') }}</h3>
            <p class="text-gray-600 mb-6">{{ __('messages.contact_support_prompt') }}</p>
            <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                {{ __('messages.contact_us') }}
            </a>
        </div>
    </div>
</div>
@endsection
