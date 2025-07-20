@extends('layouts.app')

@section('title', __('messages.page_not_found') . ' - VideoParser.top')
@section('description', __('messages.page_not_found_description'))

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <div>
            <div class="mx-auto h-32 w-32 text-gray-400">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.009-5.824-2.562M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <h1 class="mt-6 text-6xl font-bold text-gray-900">404</h1>
            <h2 class="mt-2 text-3xl font-bold text-gray-900">{{ __('messages.page_not_found') }}</h2>
            <p class="mt-2 text-sm text-gray-600">{{ __('messages.page_not_found_message') }}</p>
        </div>
        
        <div class="space-y-4">
            <a href="{{ localized_url('/') }}" 
               class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                {{ __('messages.back_to_home') }}
            </a>
            
            <a href="{{ localized_url('/help') }}" 
               class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                {{ __('messages.get_help') }}
            </a>
        </div>
        
        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('messages.popular_pages') }}</h3>
            <div class="space-y-2">
                <a href="{{ localized_url('/batch-download') }}" class="block text-blue-600 hover:text-blue-500 transition-colors">{{ __('messages.batch_download') }}</a>
                <a href="{{ localized_url('/api') }}" class="block text-blue-600 hover:text-blue-500 transition-colors">{{ __('messages.api_service') }}</a>
                <a href="{{ localized_url('/help') }}" class="block text-blue-600 hover:text-blue-500 transition-colors">{{ __('messages.help_center') }}</a>
                <a href="{{ localized_url('/contact') }}" class="block text-blue-600 hover:text-blue-500 transition-colors">{{ __('messages.contact_us') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection