@extends('pages.layout')

@section('title', $articleData['title'] . ' - ' . __('messages.help_center') . ' - besttik.com')
@section('description', 'Learn about ' . $articleData['title'] . ' in our comprehensive help guide.')

@section('hero-icon')
<div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl flex items-center justify-center mx-auto shadow-xl">
    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
    </svg>
</div>
@endsection

@section('page-title', $articleData['title'])

@section('page-description')
{{ __('messages.comprehensive_guide') ?? '详细指南' }}
@endsection

@section('page-content')
<div class="max-w-4xl mx-auto">
    <!-- 面包屑导航 -->
    <nav class="flex items-center space-x-2 text-sm text-gray-600 mb-8">
        <a href="{{ localized_url('/help') }}" class="hover:text-blue-600 transition-colors">{{ __('messages.help_center') }}</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <a href="{{ localized_url('/help/' . $category) }}" class="hover:text-blue-600 transition-colors">{{ __('messages.' . str_replace('-', '_', $category)) ?? ucfirst(str_replace('-', ' ', $category)) }}</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-900 font-medium">{{ $articleData['title'] }}</span>
    </nav>

    <!-- 文章内容 -->
    <article class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        <!-- 文章头部 -->
        <div class="px-8 py-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $articleData['title'] }}</h1>
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __('messages.last_updated') }}: {{ $articleData['last_updated'] ?? '2024-01-15' }}
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="printArticle()" class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="{{ __('messages.print_article') }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                    </button>
                    <button onclick="shareArticle()" class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="{{ __('messages.share_article') }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- 文章正文 -->
        <div class="px-8 py-6">
            <div class="prose prose-lg max-w-none">
                @if(isset($articleData['content']))
                    @foreach($articleData['content'] as $section)
                        @if($section['type'] === 'text')
                            <p class="text-gray-700 leading-relaxed mb-6">{{ $section['content'] }}</p>
                        @elseif($section['type'] === 'steps')
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ $section['title'] }}</h3>
                            <ol class="list-decimal list-inside space-y-3 mb-6">
                                @foreach($section['steps'] as $step)
                                    <li class="text-gray-700">{{ $step }}</li>
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
                                        <p class="text-blue-700">{{ $section['content'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @elseif($section['type'] === 'section')
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ $section['title'] }}</h3>
                            <p class="text-gray-700 leading-relaxed mb-6">{{ $section['content'] }}</p>
                        @endif
                    @endforeach
                @else
                    <!-- 默认内容，如果没有具体的文章内容 -->
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('messages.content_coming_soon') ?? '内容即将推出' }}</h3>
                        <p class="text-gray-600">{{ __('messages.content_development_message') ?? '我们正在为您准备详细的帮助内容，敬请期待。' }}</p>
                        <div class="mt-6">
                            <a href="{{ localized_url('/contact') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                {{ __('messages.contact_for_help') ?? '联系我们获取帮助' }}
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- 文章底部 -->
        <div class="px-8 py-6 bg-gray-50 border-t border-gray-200">
            <!-- 文章评价 -->
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

            <!-- 相关文章 -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('messages.related_articles') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- 这里可以添加相关文章的推荐 -->
                    <a href="{{ localized_url('/help') }}" class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 text-sm">{{ __('messages.browse_all_articles') ?? '浏览所有文章' }}</h4>
                            <p class="text-xs text-gray-600">{{ __('messages.find_more_help') ?? '查找更多帮助内容' }}</p>
                        </div>
                    </a>
                    <a href="{{ localized_url('/contact') }}" class="flex items-center p-3 bg-white rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900 text-sm">{{ __('messages.contact_support') }}</h4>
                            <p class="text-xs text-gray-600">{{ __('messages.get_personal_help') ?? '获取个人帮助' }}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </article>
</div>

<script>
function printArticle() {
    window.print();
}

function shareArticle() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $articleData["title"] }}',
            text: '{{ __("messages.helpful_article_share") ?? "查看这篇有用的帮助文章" }}',
            url: window.location.href
        });
    } else {
        // 复制链接到剪贴板
        navigator.clipboard.writeText(window.location.href).then(function() {
            alert('{{ __("messages.link_copied") }}');
        });
    }
}

function rateArticle(rating) {
    // 这里可以发送评价到后端
    console.log('Article rated:', rating);

    if (rating === 'helpful') {
        alert('{{ __("messages.thanks_for_feedback") ?? "感谢您的反馈！" }}');
    } else {
        // 可以显示改进建议表单
        const feedback = prompt('{{ __("messages.improve_article") ?? "请告诉我们如何改进这篇文章：" }}');
        if (feedback) {
            console.log('Improvement suggestion:', feedback);
            alert('{{ __("messages.feedback_received") ?? "感谢您的建议，我们会持续改进！" }}');
        }
    }
}
</script>
@endsection

@section('cta-section')
<h2 class="text-3xl font-bold text-white mb-4 heading-elegant">{{ __('messages.still_need_help') }}</h2>
<p class="text-xl text-blue-100 mb-8 body-light">{{ __('messages.contact_support_description') }}</p>
<div class="flex flex-col sm:flex-row gap-4 justify-center">
    <a href="{{ localized_url('/contact') }}" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200 ui-text">
        {{ __('messages.contact_support') }}
        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
    </a>
    <a href="{{ localized_url('/help/' . $category) }}" class="inline-flex items-center px-8 py-4 bg-blue-500 text-white font-semibold rounded-xl hover:bg-blue-400 transition-colors duration-200 ui-text">
        {{ __('messages.back_to_category') ?? '返回分类' }}
        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
    </a>
</div>
@endsection
