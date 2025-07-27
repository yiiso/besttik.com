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
<div class="max-w-7xl mx-auto">
    <!-- 搜索框 -->
    <div class="mb-8" id="help-search-section">
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

    <!-- 主要内容区域 -->
    <div class="flex gap-8">
        <!-- 左侧导航 -->
        <div class="w-64 flex-shrink-0">
            <div class="bg-white rounded-2xl border border-gray-200 sticky top-4">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('messages.help_categories') }}</h3>
                    <nav class="space-y-2">
                        @foreach($categories as $categoryKey => $category)
                        <div class="category-section">
                            <button 
                                class="category-toggle w-full flex items-center justify-between p-3 text-left hover:bg-gray-50 rounded-lg transition-colors"
                                onclick="toggleCategory('{{ $categoryKey }}')"
                            >
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-{{ $category['color'] }}-100 rounded-lg flex items-center justify-center mr-3">
                                        @if($category['icon'] === 'academic-cap')
                                            <svg class="w-4 h-4 text-{{ $category['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                            </svg>
                                        @elseif($category['icon'] === 'download')
                                            <svg class="w-4 h-4 text-{{ $category['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        @elseif($category['icon'] === 'globe-alt')
                                            <svg class="w-4 h-4 text-{{ $category['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9" />
                                            </svg>
                                        @elseif($category['icon'] === 'user-circle')
                                            <svg class="w-4 h-4 text-{{ $category['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @elseif($category['icon'] === 'exclamation-triangle')
                                            <svg class="w-4 h-4 text-{{ $category['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        @elseif($category['icon'] === 'code')
                                            <svg class="w-4 h-4 text-{{ $category['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                            </svg>
                                        @endif
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $category['title'] }}</span>
                                </div>
                                <svg class="w-4 h-4 text-gray-500 transform transition-transform category-arrow" id="arrow-{{ $categoryKey }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                            <div class="category-articles {{ isset($currentCategory) && $currentCategory === $categoryKey ? '' : 'hidden' }} ml-11 mt-2 space-y-1" id="articles-{{ $categoryKey }}">
                                @foreach($category['articles'] as $articleKey => $articleTitle)
                                <a 
                                    href="{{ localized_url('/help/' . $categoryKey . '/' . $articleKey) }}"
                                    class="article-link block w-full text-left p-2 text-sm {{ isset($article) && $article === $articleKey && isset($currentCategory) && $currentCategory === $categoryKey ? 'bg-blue-100 text-blue-600' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50' }} rounded transition-colors"
                                    onclick="handleHelpNavigation(event)"
                                >
                                    {{ $articleTitle }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </nav>
                </div>
            </div>
        </div>

        <!-- 右侧内容区域 -->
        <div class="flex-1">
            <div class="bg-white rounded-2xl border border-gray-200">
                <div class="p-8">
                    @if(isset($articleData))
                        <!-- 文章内容 -->
                        <div class="mb-6">
                            <nav class="flex items-center space-x-2 text-sm text-gray-600 mb-4">
                                <a href="{{ localized_url('/help') }}" class="hover:text-blue-600 transition-colors" onclick="handleHelpNavigation(event)">{{ __('messages.help_center') }}</a>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                <a href="{{ localized_url('/help/' . $currentCategory) }}" class="hover:text-blue-600 transition-colors" onclick="handleHelpNavigation(event)">{{ isset($categories[$currentCategory]['title']) ? $categories[$currentCategory]['title'] : ucfirst(str_replace('-', ' ', $currentCategory)) }}</a>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                <span class="text-gray-900 font-medium">{{ $articleData['title'] }}</span>
                            </nav>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $articleData['title'] }}</h1>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('messages.last_updated') }}: {{ $articleData['last_updated'] ?? '2024-01-15' }}
                            </div>
                        </div>

                        <!-- 文章正文 -->
                        <div class="prose prose-lg max-w-none">
                            @if(isset($articleData['content']) && is_array($articleData['content']))
                                @foreach($articleData['content'] as $section)
                                    @if($section['type'] === 'text')
                                        <p class="text-gray-700 leading-relaxed mb-6">{!! \App\Http\Controllers\HelpController::processHelpContent($section['content']) !!}</p>
                                    @elseif($section['type'] === 'section')
                                        <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ $section['title'] }}</h3>
                                        <div class="text-gray-700 leading-relaxed mb-6">{!! \App\Http\Controllers\HelpController::processHelpContent($section['content']) !!}</div>
                                    @elseif($section['type'] === 'steps')
                                        <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ $section['title'] }}</h3>
                                        <ol class="list-decimal list-inside space-y-3 mb-6">
                                            @foreach($section['steps'] as $step)
                                                <li class="text-gray-700">{!! \App\Http\Controllers\HelpController::processHelpContent($step) !!}</li>
                                            @endforeach
                                        </ol>
                                    @elseif($section['type'] === 'tip')
                                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                                            <div class="flex">
                                                <div class="flex-shrink-0">
                                                    <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-blue-700">{!! \App\Http\Controllers\HelpController::processHelpContent($section['content']) !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>

                        <!-- 文章底部 -->
                        <div class="mt-12 pt-8 border-t border-gray-200">
                            <div class="text-center mb-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('messages.helpful_article') }}</h3>
                                <div class="flex items-center justify-center space-x-4">
                                    <button onclick="rateArticle('helpful')" class="flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                        </svg>
                                        {{ __('messages.yes_helpful') }}
                                    </button>
                                    <button onclick="rateArticle('not-helpful')" class="flex items-center px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018c.163 0 .326.02.485.06L17 4m-7 10v2a2 2 0 002 2h.095c.5 0 .905-.405.905-.905 0-.714.211-1.412.608-2.006L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5" />
                                        </svg>
                                        {{ __('messages.no_helpful') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    @elseif(isset($categoryData))
                        <!-- 分类页面内容 -->
                        <div class="mb-6">
                            <nav class="flex items-center space-x-2 text-sm text-gray-600 mb-4">
                                <a href="{{ localized_url('/help') }}" class="hover:text-blue-600 transition-colors" onclick="handleHelpNavigation(event)">{{ __('messages.help_center') }}</a>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                <span class="text-gray-900 font-medium">{{ $categoryData['title'] }}</span>
                            </nav>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $categoryData['title'] }}</h1>
                            <p class="text-gray-600 mb-8 text-lg">{{ $categoryData['description'] }}</p>
                        </div>

                        <!-- 文章列表 -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($categoryData['articles'] as $articleKey => $articleTitle)
                            <a href="{{ localized_url('/help/' . $currentCategory . '/' . $articleKey) }}" class="group" onclick="handleHelpNavigation(event)">
                                <div class="bg-gray-50 hover:bg-gray-100 rounded-2xl p-6 transition-all duration-200">
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
                                    <p class="text-gray-600 text-sm">{{ __('messages.click_to_read_full_article') ?? '点击阅读完整文章' }}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    @else
                        <!-- 默认显示欢迎内容 -->
                        <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ __('messages.welcome_to_help_center') ?? '欢迎使用帮助中心' }}</h1>
                        <p class="text-gray-600 mb-8 text-lg">{{ __('messages.help_center_welcome_desc') ?? '请从左侧选择您需要了解的主题，或使用上方的搜索功能快速找到答案。' }}</p>
                        
                        <!-- 热门问题 -->
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ __('messages.popular_questions') }}</h2>
                            <div class="space-y-3">
                                @foreach($popularQuestions as $index => $qa)
                                <a 
                                    href="{{ localized_url('/help/' . $qa['category'] . '/' . $qa['article']) }}"
                                    class="block w-full text-left p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors"
                                    onclick="handleHelpNavigation(event)"
                                >
                                    <h3 class="font-medium text-gray-900">{{ $qa['question'] }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit(strip_tags($qa['answer']), 100) }}</p>
                                </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- 快速链接 -->
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ __('messages.quick_links') ?? '快速链接' }}</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <a href="{{ localized_url('/contact') }}" class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
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
                                
                                <a href="{{ localized_url('/api') }}" class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
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
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// 切换分类展开/收起
function toggleCategory(categoryKey) {
    const articles = document.getElementById(`articles-${categoryKey}`);
    const arrow = document.getElementById(`arrow-${categoryKey}`);
    
    if (articles.classList.contains('hidden')) {
        // 展开当前分类
        articles.classList.remove('hidden');
        arrow.style.transform = 'rotate(90deg)';
    } else {
        articles.classList.add('hidden');
        arrow.style.transform = 'rotate(0deg)';
    }
}

// 处理帮助中心导航，确保滚动到搜索框位置
function handleHelpNavigation(event) {
    // 在新页面加载后滚动到搜索框
    // 这里我们使用sessionStorage来标记需要滚动
    sessionStorage.setItem('scrollToSearch', 'true');
}

// 文章评价
function rateArticle(rating) {
    if (rating === 'helpful') {
        alert('{{ __("messages.thanks_for_feedback") ?? "感谢您的反馈！" }}');
    } else {
        const feedback = prompt('{{ __("messages.improve_article") ?? "请告诉我们如何改进这篇文章：" }}');
        if (feedback) {
            alert('{{ __("messages.feedback_received") ?? "感谢您的建议，我们会持续改进！" }}');
        }
    }
}

// 页面加载完成后的初始化
document.addEventListener('DOMContentLoaded', function() {
    // 如果当前在某个分类页面，自动展开对应分类
    @if(isset($currentCategory))
    const currentCategoryKey = '{{ $currentCategory }}';
    const articles = document.getElementById(`articles-${currentCategoryKey}`);
    const arrow = document.getElementById(`arrow-${currentCategoryKey}`);
    if (articles && arrow) {
        articles.classList.remove('hidden');
        arrow.style.transform = 'rotate(90deg)';
    }
    @endif

    // 自动滚动到搜索框位置
    // 检查是否需要滚动（从其他帮助页面导航过来）
    const shouldScrollToSearch = sessionStorage.getItem('scrollToSearch');
    
    // 延迟执行以确保页面完全加载
    setTimeout(function() {
        const searchSection = document.getElementById('help-search-section');
        if (searchSection && (shouldScrollToSearch === 'true' || window.location.pathname.includes('/help/'))) {
            // 计算搜索框位置，留出一些顶部空间
            const offsetTop = searchSection.offsetTop - 20;
            
            // 平滑滚动到搜索框位置
            window.scrollTo({
                top: offsetTop,
                behavior: 'smooth'
            });
            
            // 清除标记
            sessionStorage.removeItem('scrollToSearch');
        }
    }, 100);
});
</script>
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