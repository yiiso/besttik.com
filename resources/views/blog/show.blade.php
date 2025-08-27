@extends('layouts.app')

@section('title', $post->meta_title ?: $post->title . ' - Video Parsing Technology Blog | BestTik')
@section('description', $post->meta_description ?: $post->excerpt)
@section('keywords', $post->meta_keywords ?: implode(',', $post->tags ?: []))

@push('head')
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "BlogPosting",
        "headline": "{{ $post->title }}",
        "description": "{{ $post->excerpt }}",
        "image": "{{ $post->featured_image ?: asset('images/default-blog.jpg') }}",
        "author": {
            "@@type": "Organization",
            "name": "BestTik"
        },
        "publisher": {
            "@@type": "Organization",
            "name": "BestTik",
            "logo": {
                "@@type": "ImageObject",
                "url": "{{ asset('images/logo.png') }}"
            }
        },
        "datePublished": "{{ $post->published_at->toISOString() }}",
        "dateModified": "{{ $post->updated_at->toISOString() }}",
        "mainEntityOfPage": {
            "@@type": "WebPage",
            "@@id": "{{ url()->current() }}"
        }
    }
    </script>
@endpush

@section('content')
<article class="py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-8">
            <a href="{{ route('blog.index') }}" class="hover:text-blue-600">Blog</a>
            <span>›</span>
            <a href="{{ route('blog.category', $post->category->slug) }}" class="hover:text-blue-600">{{ $post->category->name }}</a>
            <span>›</span>
            <span class="text-gray-900">{{ $post->title }}</span>
        </nav>

        <!-- Article Header -->
        <header class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-4">
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium">
                    {{ $post->category->name }}
                </span>
                <span class="mx-2">•</span>
                <time>{{ $post->published_at->format('M j, Y') }}</time>
                <span class="mx-2">•</span>
                <span>{{ $post->reading_time }} min read</span>
                <span class="mx-2">•</span>
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    {{ $post->views }} views
                </span>
            </div>

            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>

            <p class="text-xl text-gray-600 leading-relaxed">{{ $post->excerpt }}</p>
        </header>

        <!-- Featured Image -->
        @if($post->featured_image)
            <div class="mb-8">
                <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full rounded-xl shadow-lg">
            </div>
        @endif

        <!-- Article Content -->
        <div class="prose prose-sm text-sm  max-w-none">
            {!! $post->content !!}
        </div>

        <!-- Tags -->
        @if($post->tags && count($post->tags) > 0)
            <div class="mt-8 pt-8 border-t border-gray-200">
                <div class="flex flex-wrap gap-2">
                    <span class="text-gray-600 font-medium">Tags:</span>
                    @foreach($post->tags as $tag)
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">{{ $tag }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Share Buttons -->
        <div class="mt-8 pt-8 border-t border-gray-200">
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-medium">Share this article:</span>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}"
                   target="_blank"
                   class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                    Twitter
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                   target="_blank"
                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Facebook
                </a>
                <button onclick="copyToClipboard('{{ url()->current() }}')"
                        class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                    Copy Link
                </button>
            </div>
        </div>
    </div>
</article>

<!-- Related Articles -->
@if($relatedPosts->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Related Articles</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedPosts as $relatedPost)
                <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    @if($relatedPost->featured_image)
                        <div class="aspect-video bg-gray-200">
                            <img src="{{ $relatedPost->featured_image }}" alt="{{ $relatedPost->title }}" class="w-full h-full object-cover">
                        </div>
                    @endif

                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 mb-2 hover:text-blue-600 transition-colors">
                            <a href="{{ route('blog.show', $relatedPost->slug) }}">{{ $relatedPost->title }}</a>
                        </h3>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $relatedPost->excerpt }}</p>
                        <div class="text-xs text-gray-500">
                            {{ $relatedPost->published_at->format('M j, Y') }}
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Link copied to clipboard!');
    }, function(err) {
        console.error('Copy failed: ', err);
    });
}
</script>
@endsection
