@extends('layouts.app')

@section('title', '使用帮助 - 视频解析下载教程 - VideoParser.top')
@section('description', '详细的视频解析下载使用教程，支持抖音、TikTok、Instagram等平台视频解析下载指南。')
@section('keywords', '视频解析教程,视频下载教程,抖音解析教程,使用帮助')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- 页面标题 -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">使用帮助指南</h1>
            <p class="text-xl text-gray-600">快速学会使用VideoParser.top解析下载各平台视频</p>
        </div>

        <!-- 快速开始 -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                快速开始
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-lg font-bold text-blue-600">1</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">复制视频链接</h3>
                    <p class="text-sm text-gray-600">从任意支持的平台复制视频链接</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-lg font-bold text-green-600">2</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">粘贴到输入框</h3>
                    <p class="text-sm text-gray-600">将链接粘贴到首页解析框中</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-lg font-bold text-purple-600">3</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">点击解析</h3>
                    <p class="text-sm text-gray-600">点击解析按钮开始分析视频</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-lg font-bold text-orange-600">4</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">下载视频</h3>
                    <p class="text-sm text-gray-600">选择画质格式并下载保存</p>
                </div>
            </div>
        </div>

        <!-- 支持平台 -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                支持平台
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <span class="font-medium text-gray-900">抖音</span>
                </div>
                <!-- <div class="flex items-center p-3 bg-gray-50 rounded-lg"><span class="font-medium text-gray-900">YouTube</span></div> 已移除 -->
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <span class="font-medium text-gray-900">TikTok</span>
                </div>
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <span class="font-medium text-gray-900">Instagram</span>
                </div>
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <span class="font-medium text-gray-900">Facebook</span>
                </div>
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <span class="font-medium text-gray-900">Twitter</span>
                </div>
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <span class="font-medium text-gray-900">小红书</span>
                </div>
                <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                    <span class="font-medium text-gray-900">B站</span>
                </div>
            </div>
        </div>

        <!-- 常见问题 -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                常见问题
            </h2>
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">服务是否免费？</h3>
                    <p class="text-gray-600">是的，我们提供完全免费的视频解析服务。游客用户每日有一定解析次数，注册用户可获得更多次数。</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">支持哪些视频格式？</h3>
                    <p class="text-gray-600">支持MP4、WebM、FLV、M3U8等多种格式，具体格式取决于原平台提供的选项。</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">下载失败怎么办？</h3>
                    <p class="text-gray-600">请检查网络连接，确认视频链接有效，尝试刷新页面重新解析，或联系我们获取帮助。</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">是否支持批量下载？</h3>
                    <p class="text-gray-600">是的，我们提供批量下载功能，您可以一次性添加多个视频链接进行批量处理。</p>
                </div>
            </div>
        </div>

        <!-- 联系支持 -->
        <div class="text-center mt-12">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">需要更多帮助？</h3>
            <p class="text-gray-600 mb-6">如果您遇到任何问题，欢迎联系我们的支持团队</p>
            <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                联系我们
            </a>
        </div>
    </div>
</div>
@endsection