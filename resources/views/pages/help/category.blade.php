@extends('pages.layout')

@section('title', $categoryData['title'] . ' - ' . __('messages.help_center') . ' - VideoParser.top')
@section('description', $categoryData['description'])

@section('hero-icon')
<div class="w-20 h-20 bg-gradient-to-br from-{{ $categoryData['color'] }}-500 to-{{ $categoryData['color'] }}-600 rounded-3xl flex items-center justify-center mx-auto shadow-xl">
    @if($categoryData['icon'] === 'academic-cap')
        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
        </svg>
    @elseif($categoryData['icon'] === 'download')
        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
        </svg>
    @elseif($categoryData['icon'] === 'globe-alt')
        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9" />
        </svg>
    @elseif($categoryData['icon'] === 'user-circle')
        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    @elseif($categoryData['icon'] === 'exclamation-triangle')
        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
    @elseif($categoryData['icon'] === 'code')
        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
        </svg>
    @endif
</div>
@endsection

@section('page-title', $categoryData['title'])

@section('page-description')
{{ $categoryData['description'] }}
@endsection

@section('page-content')
<div class="space-y-8">
    <!-- 面包屑导航 -->
    <nav class="flex items-center space-x-2 text-sm text-gray-600">
        <a href="{{ localized_url('/help') }}" class="hover:text-blue-600 transition-colors">{{ __('messages.help_center') }}</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-900 font-medium">{{ $categoryData['title'] }}</span>
    </nav>

    <!-- 文章列表 -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($categoryData['articles'] as $articleKey => $articleTitle)
        <a href="{{ localized_url('/help/' . $category . '/' . $articleKey) }}" class="group">
            <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg hover:border-{{ $categoryData['color'] }}-200 transition-all duration-200">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 bg-{{ $categoryData['color'] }}-100 rounded-lg flex items-center justify-center group-hover:bg-{{ $categoryData['color'] }}-200 transition-colors">
                        <svg class="w-5 h-5 text-{{ $categoryData['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-{{ $categoryData['color'] }}-600 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-{{ $categoryData['color'] }}-600 transition-colors">{{ $articleTitle }}</h3>
                <p class="text-gray-600 body-light text-sm">{{ __('messages.click_to_read_full_article') ?? '点击阅读完整文章' }}</p>
            </div>
        </a>
        @endforeach
    </div>

    <!-- 相关分类推荐 -->
    <div class="bg-gray-50 rounded-2xl p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">{{ __('messages.related_categories') ?? '相关分类' }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- 这里可以添加相关分类的推荐 -->
            <a href="{{ localized_url('/help') }}" class="flex items-center p-4 bg-white rounded-xl hover:shadow-md transition-shadow">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h2a2 2 0 012 2v0H8v0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900 text-sm">{{ __('messages.all_categories') }}</h3>
                    <p class="text-xs text-gray-600">{{ __('messages.browse_all_help_topics') ?? '浏览所有帮助主题' }}</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

@section('cta-section')
<h2 class="text-3xl font-bold text-white mb-4 heading-elegant">{{ __('messages.need_more_help') ?? '需要更多帮助？' }}</h2>
<p class="text-xl text-blue-100 mb-8 body-light">{{ __('messages.contact_support_description') }}</p>
<div class="flex flex-col sm:flex-row gap-4 justify-center">
    <a href="{{ localized_url('/contact') }}" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200 ui-text">
        {{ __('messages.contact_support') }}
        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
    </a>
    <a href="{{ localized_url('/help') }}" class="inline-flex items-center px-8 py-4 bg-blue-500 text-white font-semibold rounded-xl hover:bg-blue-400 transition-colors duration-200 ui-text">
        {{ __('messages.back_to_help_center') }}
        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
    </a>
</div>
@endsection