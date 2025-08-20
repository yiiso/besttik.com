@extends('pages.layout')

@section('title', __('messages.api_service') . ' - VideoParser.top')
@section('description', 'Integrate VideoParser.top API into your applications. Powerful video parsing API with comprehensive documentation and examples.')

@section('hero-icon')
<div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-600 rounded-3xl flex items-center justify-center mx-auto shadow-xl">
    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
    </svg>
</div>
@endsection

@section('page-title', __('messages.api_service'))

@section('page-description')
{{ __('messages.api_service_description') }}
@endsection

@section('page-content')
<div class="space-y-12">
    <!-- API Overview -->
    <div class="text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-6 heading-modern">{{ __('messages.powerful_api') }}</h2>
        <p class="text-lg text-gray-600 body-regular">{{ __('messages.api_overview_description') }}</p>
    </div>

    <!-- API Features -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="text-center p-6 bg-gray-50 rounded-2xl">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2 heading-modern">{{ __('messages.fast_response') }}</h3>
            <p class="text-gray-600 body-light">{{ __('messages.fast_response_description') }}</p>
        </div>

        <div class="text-center p-6 bg-gray-50 rounded-2xl">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2 heading-modern">{{ __('messages.secure_reliable') }}</h3>
            <p class="text-gray-600 body-light">{{ __('messages.api_secure_description') }}</p>
        </div>

        <div class="text-center p-6 bg-gray-50 rounded-2xl">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2 heading-modern">{{ __('messages.global_support') }}</h3>
            <p class="text-gray-600 body-light">{{ __('messages.api_global_description') }}</p>
        </div>
    </div>

    <!-- API Example -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-6 heading-modern">{{ __('messages.api_example') }}</h2>
        <div class="bg-gray-900 rounded-2xl p-6 overflow-x-auto">
            <pre class="text-green-400 font-mono text-sm"><code>curl -X POST "https://api.videoparser.top/v1/parse" \
  -H "Authorization: Bearer YOUR_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "url": "https://www.youtube.com/watch?v=example",
    "format": "mp4",
    "quality": "1080p"
  }'</code></pre>
        </div>
    </div>

    <!-- Response Example -->
    <div>
        <h3 class="text-xl font-semibold text-gray-900 mb-4 heading-modern">{{ __('messages.response_example') }}</h3>
        <div class="bg-gray-900 rounded-2xl p-6 overflow-x-auto">
            <pre class="text-blue-400 font-mono text-sm"><code>{
  "status": "success",
  "data": {
    "title": "Example Video Title",
    "thumbnail": "https://example.com/thumbnail.jpg",
    "duration": "00:03:45",
    "author": "Channel Name",
    "download_urls": {
      "1080p": "https://example.com/video_1080p.mp4",
      "720p": "https://example.com/video_720p.mp4",
      "480p": "https://example.com/video_480p.mp4"
    }
  }
}</code></pre>
        </div>
    </div>

    <!-- Pricing -->
    <div class="text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 heading-modern">{{ __('messages.api_pricing') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-gray-50 rounded-2xl p-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ __('messages.free_tier') }}</h3>
                <div class="text-3xl font-bold text-gray-900 mb-4">$0<span class="text-lg text-gray-600">/month</span></div>
                <ul class="text-gray-600 space-y-2 mb-6 body-light">
                    <li>{{ __('messages.free_requests_limit') }}</li>
                    <li>{{ __('messages.basic_support') }}</li>
                    <li>{{ __('messages.standard_quality') }}</li>
                </ul>
                <button class="w-full bg-gray-200 text-gray-800 py-3 px-6 rounded-lg font-semibold">{{ __('messages.get_started') }}</button>
            </div>

            <div class="bg-blue-600 text-white rounded-2xl p-8 transform scale-105">
                <h3 class="text-xl font-semibold mb-4">{{ __('messages.pro_tier') }}</h3>
                <div class="text-3xl font-bold mb-4">$29<span class="text-lg opacity-80">/month</span></div>
                <ul class="opacity-90 space-y-2 mb-6 body-light">
                    <li>{{ __('messages.pro_requests_limit') }}</li>
                    <li>{{ __('messages.priority_support') }}</li>
                    <li>{{ __('messages.high_quality') }}</li>
                    <li>{{ __('messages.batch_processing') }}</li>
                </ul>
                <button class="w-full bg-white text-blue-600 py-3 px-6 rounded-lg font-semibold">{{ __('messages.choose_pro') }}</button>
            </div>

            <div class="bg-gray-50 rounded-2xl p-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">{{ __('messages.enterprise_tier') }}</h3>
                <div class="text-3xl font-bold text-gray-900 mb-4">{{ __('messages.custom_pricing') }}</div>
                <ul class="text-gray-600 space-y-2 mb-6 body-light">
                    <li>{{ __('messages.unlimited_requests') }}</li>
                    <li>{{ __('messages.dedicated_support') }}</li>
                    <li>{{ __('messages.custom_integration') }}</li>
                    <li>{{ __('messages.sla_guarantee') }}</li>
                </ul>
                <button class="w-full bg-gray-900 text-white py-3 px-6 rounded-lg font-semibold">{{ __('messages.contact_sales') }}</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('cta-section')
<h2 class="text-3xl font-bold text-white mb-4 heading-elegant">{{ __('messages.ready_to_integrate') }}</h2>
<p class="text-xl text-blue-100 mb-8 body-light">{{ __('messages.api_cta_description') }}</p>
<a href="{{ localized_url('/contact') }}" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200 ui-text">
    {{ __('messages.get_api_key') }}
    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
    </svg>
</a>
@endsection

"example": {
    "url": "https://www.tiktok.com/@scout2015/video/6718335390845095173"
},