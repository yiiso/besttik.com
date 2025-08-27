@extends('layouts.app')

@section('title', 'Video Parsing Technology Blog - Latest Video Download Tech | BestTik')
@section('description', 'Professional video parsing technology blog sharing TikTok, Instagram, Facebook video download techniques, M3U8, FLV format parsing tutorials to improve video processing efficiency.')
@section('keywords', 'video parsing blog,video download technology,M3U8 parsing,FLV playback,TikTok download tutorial,video format conversion,online video parsing')

@section('content')
<section class="bg-gradient-to-br from-blue-50 to-purple-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Video Parsing Technology Blog
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Sharing the latest video download technologies, format parsing methods, and platform comparison analysis to help you master professional video processing skills
            </p>
        </div>

        <!-- Search Bar -->
        <div class="max-w-2xl mx-auto mb-12">
            <form method="GET" action="{{ route('blog.index') }}" class="relative">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Search articles..." 
                    class="w-full px-6 py-4 text-lg border border-gray-300 rounded-full focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                <button type="submit" class="absolute right-2 top-2 bottom-2 px-6 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors">
                    Search
                </button>
            </form>
        </div>
    </div>
</section>

<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- 主内容区 -->
            <div class="lg:col-span-3">
                @if($posts->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                        @foreach($posts as $post)
                            <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                @if($post->featured_image)
                                    <div class="aspect-video bg-gray-200">
                                        <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                                
                                <div class="p-6">
                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium">
                                            {{ $post->category->name }}
                                        </span>
                                        <span class="mx-2">•</span>
                                        <time>{{ $post->published_at->format('M j, Y') }}</time>
                                        <span class="mx-2">•</span>
                                        <span>{{ $post->reading_time }} min read</span>
                                    </div>
                                    
                                    <h2 class="text-xl font-bold text-gray-900 mb-3 hover:text-blue-600 transition-colors">
                                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                    </h2>
                                    
                                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>
                                    
                                    <div class="flex items-center justify-between">
                                        <a href="{{ route('blog.show', $post->slug) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                            Read More →
                                        </a>
                                        <div class="flex items-center text-gray-500 text-sm">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            {{ $post->views }}
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- 分页 -->
                    <div class="flex justify-center">
                        {{ $posts->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-gray-400 text-6xl mb-4">📝</div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No Articles Found</h3>
                        <p class="text-gray-600">We're working hard to create more quality content. Stay tuned!</p>
                    </div>
                @endif
            </div>

            <!-- 侧边栏 -->
            <div class="lg:col-span-1">
                <!-- Categories -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Article Categories</h3>
                    <div class="space-y-2">
                        <a href="{{ route('blog.index') }}" class="flex items-center justify-between text-gray-600 hover:text-blue-600 transition-colors {{ !request('category') ? 'text-blue-600 font-medium' : '' }}">
                            <span>All Articles</span>
                            <span class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $posts->total() }}</span>
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('blog.index', ['category' => $category->slug]) }}" class="flex items-center justify-between text-gray-600 hover:text-blue-600 transition-colors {{ request('category') === $category->slug ? 'text-blue-600 font-medium' : '' }}">
                                <span>{{ $category->name }}</span>
                                <span class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $category->published_posts_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Articles -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Articles</h3>
                    <div class="space-y-4">
                        @foreach($recentPosts as $recentPost)
                            <div class="border-b border-gray-100 pb-4 last:border-b-0 last:pb-0">
                                <h4 class="font-medium text-gray-900 hover:text-blue-600 transition-colors mb-1">
                                    <a href="{{ route('blog.show', $recentPost->slug) }}">{{ $recentPost->title }}</a>
                                </h4>
                                <div class="text-sm text-gray-500">
                                    {{ $recentPost->published_at->format('M j, Y') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection