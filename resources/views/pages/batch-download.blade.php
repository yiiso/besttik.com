@extends('pages.layout')

@section('title', __('messages.batch_download') . ' - besttik.com')
@section('description', 'Batch download multiple videos at once with besttik.com. Save time and effort with our powerful batch processing feature.')

@section('hero-icon')
<div class="w-20 h-20 bg-gradient-to-br from-green-500 to-blue-600 rounded-3xl flex items-center justify-center mx-auto shadow-xl">
    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
    </svg>
</div>
@endsection

@section('page-title', __('messages.batch_download'))

@section('page-description')
{{ __('messages.batch_download_description') }}
@endsection

@section('page-content')
<div class="space-y-12">
    <!-- Feature Overview -->
    <div class="text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-6 heading-modern">{{ __('messages.powerful_batch_processing') }}</h2>
        <p class="text-lg text-gray-600 body-regular">{{ __('messages.batch_processing_description') }}</p>
    </div>

    <!-- Features Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="text-center p-6 bg-gray-50 rounded-2xl">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2 heading-modern">{{ __('messages.lightning_fast') }}</h3>
            <p class="text-gray-600 body-light">{{ __('messages.lightning_fast_description') }}</p>
        </div>

        <div class="text-center p-6 bg-gray-50 rounded-2xl">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2 heading-modern">{{ __('messages.smart_queue') }}</h3>
            <p class="text-gray-600 body-light">{{ __('messages.smart_queue_description') }}</p>
        </div>

        <div class="text-center p-6 bg-gray-50 rounded-2xl">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2 heading-modern">{{ __('messages.format_options') }}</h3>
            <p class="text-gray-600 body-light">{{ __('messages.format_options_description') }}</p>
        </div>

        <div class="text-center p-6 bg-gray-50 rounded-2xl">
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2 heading-modern">{{ __('messages.progress_tracking') }}</h3>
            <p class="text-gray-600 body-light">{{ __('messages.progress_tracking_description') }}</p>
        </div>
    </div>

    <!-- How It Works -->
    <div class="text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 heading-modern">{{ __('messages.how_it_works') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">1</div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.add_links') }}</h3>
                <p class="text-gray-600 body-light">{{ __('messages.add_links_description') }}</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">2</div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.configure_settings') }}</h3>
                <p class="text-gray-600 body-light">{{ __('messages.configure_settings_description') }}</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">3</div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.download_all') }}</h3>
                <p class="text-gray-600 body-light">{{ __('messages.download_all_description') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('cta-section')
<h2 class="text-3xl font-bold text-white mb-4 heading-elegant">{{ __('messages.ready_to_start') }}</h2>
<p class="text-xl text-blue-100 mb-8 body-light">{{ __('messages.batch_download_cta') }}</p>
<a href="{{ localized_url('/') }}" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-200 ui-text">
    {{ __('messages.try_batch_download') }}
    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
    </svg>
</a>
@endsection
