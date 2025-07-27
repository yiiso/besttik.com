@extends('pages.layout')

@section('title', __('messages.help_center') . ' - VideoParser.top')
@section('description', __('messages.help_center_description'))

@section('hero-icon')
<div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl flex items-center justify-center mx-auto shadow-xl">
    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
</div>
@endsection

@section('page-title', __('messages.help_center'))

@section('page-description')
{{ __('messages.help_center_description') }}
@endsection

@section('page-content')
<div class="space-y-12">
    <!-- 搜索框 -->
    <div class="text-center">
        <div class="max-w-2xl mx-auto">
            <form action="{{ localized_url('/help/search') }}" method="GET" class="relative">
                <input 
                    type="text" 
                    name="q"
                    placeholder="{{ __('messages.search_help_placeholder') }}" 
                    class="w-full px-6 py-4 text-lg border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:outline-none transition-colors pr-16"
                    value="{{ request('q') }}"
                >
                <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white p-2 rounded-xl hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- 帮助分类 -->
    <div>
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center heading-modern">{{ __('messages.help_categories') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
            @foreach($categories as $categoryKey => $category)
            <a href="{{ localized_url('/help/' . $categoryKey) }}" class="group">
                <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg hover:border-{{ $category['color'] }}-200 transition-all duration-200 h-full flex flex-col">
                    <div class="w-12 h-12 bg-{{ $category['color'] }}-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-{{ $category['color'] }}-200 transition-colors">
                        @if($category['icon'] === 'academic-cap')
                            <svg class="w-6 h-6 text-{{ $category['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        @elseif($category['icon'] === 'download')
                            <svg class="w-6 h-6 text-{{ $category['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        @elseif($category['icon'] === 'globe-alt')
                            <svg class="w-6 h-6 text-{{ $category['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9" />
                            </svg>
                        @elseif($category['icon'] === 'user-circle')
                            <svg class="w-6 h-6 text-{{ $category['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        @elseif($category['icon'] === 'exclamation-triangle')
                            <svg class="w-6 h-6 text-{{ $category['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        @elseif($category['icon'] === 'code')
                            <svg class="w-6 h-6 text-{{ $category['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        @endif
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-{{ $category['color'] }}-600 transition-colors">{{ $category['title'] }}</h3>
                    <p class="text-gray-600 body-light mb-4 flex-grow">{{ $category['description'] }}</p>
                    <div class="text-sm text-{{ $category['color'] }}-600 font-medium mt-auto">
                        {{ count($category['articles']) }} {{ __('messages.articles') ?? '篇文章' }}
                        <svg class="w-4 h-4 inline ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <!-- 热门问题 -->
    <div>
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center heading-modern">{{ __('messages.popular_questions') }}</h2>
        <div class="space-y-4 max-w-4xl mx-auto">
            @foreach($popularQuestions as $index => $qa)
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
                <button 
                    class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition-colors"
                    onclick="toggleFaq({{ $index }})"
                >
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $qa['question'] }}</h3>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" id="faq-icon-{{ $index }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>
                <div class="hidden px-6 pb-4" id="faq-content-{{ $index }}">
                    <div class="text-gray-600 body-light whitespace-pre-line">{{ $qa['answer'] }}</div>
                    <div class="mt-4">
                        <a href="{{ localized_url('/help/' . $qa['category'] . '/' . $qa['article']) }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                            {{ __('messages.read_more') ?? '阅读更多' }} →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- 快速链接 -->
    <div class="bg-gray-50 rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">{{ __('messages.quick_links') ?? '快速链接' }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ localized_url('/contact') }}" class="flex items-center p-4 bg-white rounded-xl hover:shadow-md transition-shadow">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">{{ __('messages.contact_support') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('messages.get_personal_help') ?? '获取个人帮助' }}</p>
                </div>
            </a>
            
            <a href="{{ localized_url('/api') }}" class="flex items-center p-4 bg-white rounded-xl hover:shadow-md transition-shadow">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">{{ __('messages.api_documentation') }}</h3>
                    <p class="text-sm text-gray-600">{{ __('messages.developer_resources') ?? '开发者资源' }}</p>
                </div>
            </a>
            
            <a href="{{ localized_url('/') }}" class="flex items-center p-4 bg-white rounded-xl hover:shadow-md transition-shadow">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

<script>
function toggleFaq(index) {
    const content = document.getElementById(`faq-content-${index}`);
    const icon = document.getElementById(`faq-icon-${index}`);
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}
</script>
@endsection

@section('cta-section')
<h2 class="text-3xl font-bold text-white mb-4 heading-elegant">{{ __('messages.still_need_help') }}</h2>
<p class="text-xl text-blue-100 mb-8 body-light">{{ __('messages.contact_support_description') }}</p>
<a href="{{ localized_url('/contact') }}" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200 ui-text">
    {{ __('messages.contact_support') }}
    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
    </svg>
</a>
@endsection