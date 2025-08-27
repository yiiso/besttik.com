@extends('layouts.app')

@section('title', $category->meta_title ?: $category->name . ' - Video Parsing Technology Blog | BestTik')
@section('description', $category->meta_description ?: $category->description)

@section('content')
<section class="bg-gradient-to-br from-blue-50 to-purple-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-8">
            <a href="{{ route('blog.index') }}" class="hover:text-blue-600">Blog</a>
            <span>›</span>
            <span class="text-gray-900">{{ $category->name }}</span>
        </nav>

        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                {{ $category->name }}
            </h1>
            @if($category->description)
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    {{ $category->description }}
                </p>
            @endif
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
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No Articles in This Category</h3>
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
                        <a href="{{ route('blog.index') }}" class="flex items-center justify-between text-gray-600 hover:text-blue-600 transition-colors">
                            <span>All Articles</span>
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ route('blog.category', $cat->slug) }}" class="flex items-center justify-between text-gray-600 hover:text-blue-600 transition-colors {{ $cat->id === $category->id ? 'text-blue-600 font-medium' : '' }}">
                                <span>{{ $cat->name }}</span>
                                <span class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $cat->published_posts_count }}</span>
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