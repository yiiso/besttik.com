@extends('layouts.app')

@section('title', __('messages.page_not_found') . ' - VideoParser.pro')
@section('description', __('messages.page_not_found_description'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-blue-50 flex items-center justify-center">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- 404 Icon -->
        <div class="mb-8">
            <div class="w-32 h-32 bg-gradient-to-br from-blue-500 to-purple-600 rounded-3xl flex items-center justify-center mx-auto shadow-2xl">
                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
        </div>

        <!-- Error Message -->
        <h1 class="text-6xl font-bold text-gray-900 mb-4 heading-elegant">404</h1>
        <h2 class="text-3xl font-bold text-gray-900 mb-6 heading-modern">{{ __('messages.page_not_found') }}</h2>
        <p class="text-xl text-gray-600 mb-8 body-light">{{ __('messages.page_not_found_message') }}</p>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ localized_url('/') }}" class="inline-flex items-center px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors duration-200 ui-text">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                {{ __('messages.back_to_home') }}
            </a>
            
            <a href="{{ localized_url('/help') }}" class="inline-flex items-center px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-colors duration-200 ui-text">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ __('messages.get_help') }}
            </a>
        </div>

        <!-- Popular Links -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 heading-modern">{{ __('messages.popular_pages') }}</h3>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ localized_url('/') }}" class="text-blue-600 hover:text-blue-700 transition-colors">{{ __('messages.video_parser') }}</a>
                <a href="{{ localized_url('/batch-download') }}" class="text-blue-600 hover:text-blue-700 transition-colors">{{ __('messages.batch_download') }}</a>
                <a href="{{ localized_url('/api') }}" class="text-blue-600 hover:text-blue-700 transition-colors">{{ __('messages.api_service') }}</a>
                <a href="{{ localized_url('/help') }}" class="text-blue-600 hover:text-blue-700 transition-colors">{{ __('messages.help_center') }}</a>
                <a href="{{ localized_url('/contact') }}" class="text-blue-600 hover:text-blue-700 transition-colors">{{ __('messages.contact_us') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection