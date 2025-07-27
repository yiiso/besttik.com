@extends('pages.layout')

@section('title', __('messages.search_results') . ': ' . $query . ' - ' . __('messages.help_center') . ' - VideoParser.top')
@section('description', 'Search results for "' . $query . '" in VideoParser.top help center.')

@section('hero-icon')
<div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-3xl flex items-center justify-center mx-auto shadow-xl">
    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
    </svg>
</div>
@endsection

@section('page-title')
{{ __('messages.search_results') ?? '搜索结果' }}
@if($query)
    <span class="text-blue-600">: "{{ $query }}"</span>
@endif
@endsection

@section('page-description')
@if(count($results) > 0)
    {{ __('messages.found_results', ['count' => count($results)]) ?? '找到 ' . count($results) . ' 个结果' }}
@else
    {{ __('messages.no_results_found') ?? '未找到相关结果' }}
@endif
@endsection

@section('page-content')
<div class="space-y-8">
    <!-- 面包屑导航 -->
    <nav class="flex items-center space-x-2 text-sm text-gray-600">
        <a href="{{ localized_url('/help') }}" class="hover:text-blue-600 transition-colors">{{ __('messages.help_center') }}</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-900 font-medium">{{ __('messages.search_results') ?? '搜索结果' }}</span>
    </nav>

    <!-- 搜索框 -->
    <div class="max-w-2xl mx-auto">
        <form action="{{ localized_url('/help/search') }}" method="GET" class="relative">
            <input 
                type="text" 
                name="q"
                placeholder="{{ __('messages.search_help_placeholder') }}" 
                class="w-full px-6 py-4 text-lg border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:outline-none transition-colors pr-16"
                value="{{ $query }}"
                autofocus
            >
            <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white p-2 rounded-xl hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </form>
    </div>

    @if(count($results) > 0)
        <!-- 搜索结果 -->
        <div class="space-y-4">
            @foreach($results as $result)
            <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            @if($result['type'] === 'category')
                                <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded-full">{{ __('messages.category') ?? '分类' }}</span>
                            @elseif($result['type'] === 'article')
                                <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-1 rounded-full">{{ __('messages.article') ?? '文章' }}</span>
                            @elseif($result['type'] === 'faq')
                                <div class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span class="text-xs font-medium text-purple-600 bg-purple-100 px-2 py-1 rounded-full">{{ __('messages.faq') ?? '常见问题' }}</span>
                            @endif
                        </div>
                        
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            <a href="{{ $result['url'] }}" class="hover:text-blue-600 transition-colors">{{ $result['title'] }}</a>
                        </h3>
                        
                        @if(isset($result['category']))
                            <p class="text-sm text-gray-600 mb-2">{{ __('messages.in_category') ?? '在分类' }}: {{ $result['category'] }}</p>
                        @endif
                        
                        @if(isset($result['description']))
                            <p class="text-gray-600 body-light">{{ $result['description'] }}</p>
                        @endif
                    </div>
                    
                    <a href="{{ $result['url'] }}" class="ml-4 p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- 无结果状态 -->
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('messages.no_results_found') ?? '未找到相关结果' }}</h3>
            <p class="text-gray-600 mb-6">{{ __('messages.try_different_keywords') ?? '请尝试使用不同的关键词或浏览下面的建议' }}</p>
            
            <!-- 搜索建议 -->
            <div class="max-w-2xl mx-auto">
                <h4 class="text-md font-medium text-gray-900 mb-4">{{ __('messages.search_suggestions') ?? '搜索建议' }}:</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <h5 class="font-medium text-gray-900 mb-2">{{ __('messages.popular_topics') ?? '热门主题' }}</h5>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li><a href="{{ localized_url('/help/search?q=下载') }}" class="hover:text-blue-600">{{ __('messages.download') ?? '下载' }}</a></li>
                            <li><a href="{{ localized_url('/help/search?q=解析') }}" class="hover:text-blue-600">{{ __('messages.parsing') ?? '解析' }}</a></li>
                            <li><a href="{{ localized_url('/help/search?q=账户') }}" class="hover:text-blue-600">{{ __('messages.account') ?? '账户' }}</a></li>
                            <li><a href="{{ localized_url('/help/search?q=API') }}" class="hover:text-blue-600">API</a></li>
                        </ul>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <h5 class="font-medium text-gray-900 mb-2">{{ __('messages.common_issues') ?? '常见问题' }}</h5>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li><a href="{{ localized_url('/help/search?q=下载失败') }}" class="hover:text-blue-600">{{ __('messages.download_failed') ?? '下载失败' }}</a></li>
                            <li><a href="{{ localized_url('/help/search?q=浏览器') }}" class="hover:text-blue-600">{{ __('messages.browser_issues') ?? '浏览器问题' }}</a></li>
                            <li><a href="{{ localized_url('/help/search?q=限制') }}" class="hover:text-blue-600">{{ __('messages.usage_limits') ?? '使用限制' }}</a></li>
                            <li><a href="{{ localized_url('/help/search?q=平台') }}" class="hover:text-blue-600">{{ __('messages.supported_platforms') ?? '支持平台' }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- 快速链接 -->
    <div class="bg-gray-50 rounded-2xl p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6 text-center">{{ __('messages.need_more_help') ?? '需要更多帮助？' }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ localized_url('/help') }}" class="flex items-center p-4 bg-white rounded-xl hover:shadow-md transition-shadow">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">{{ __('messages.browse_help_center') ?? '浏览帮助中心' }}</h3>
                    <p class="text-sm text-gray-600">{{ __('messages.explore_all_topics') ?? '探索所有主题' }}</p>
                </div>
            </a>
            
            <a href="{{ localized_url('/contact') }}" class="flex items-center p-4 bg-white rounded-xl hover:shadow-md transition-shadow">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">{{ __('messages.contact_support') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('messages.get_personal_help') ?? '获取个人帮助' }}</p>
                </div>
            </a>
            
            <a href="{{ localized_url('/') }}" class="flex items-center p-4 bg-white rounded-xl hover:shadow-md transition-shadow">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">{{ __('messages.try_service') ?? '试用服务' }}</h3>
                    <p class="text-sm text-gray-600">{{ __('messages.start_parsing_videos') ?? '开始解析视频' }}</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

@section('cta-section')
<h2 class="text-3xl font-bold text-white mb-4 heading-elegant">{{ __('messages.still_need_help') }}</h2>
<p class="text-xl text-blue-100 mb-8 body-light">{{ __('messages.contact_support_description') }}</p>
<a href="{{ localized_url('/contact') }}" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200 ui-text">
    {{ __('messages.contact_support') }}
    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
    </svg>
</a>
@endsection