@extends('pages.layout')

@section('title', __('messages.help_center') . ' - VideoParser.pro')
@section('description', 'Get help and support for VideoParser.pro. Find answers to common questions and learn how to use our video parsing service.')

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
    <!-- Search Box -->
    <div class="text-center">
        <div class="max-w-2xl mx-auto">
            <div class="relative">
                <input type="text" placeholder="{{ __('messages.search_help') }}" class="w-full px-6 py-4 text-lg border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:outline-none transition-colors">
                <button class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-blue-600 text-white p-2 rounded-xl hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- FAQ Categories -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-gray-50 rounded-2xl p-6 hover:bg-gray-100 transition-colors cursor-pointer">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.getting_started') }}</h3>
            <p class="text-gray-600 body-light">{{ __('messages.getting_started_description') }}</p>
        </div>

        <div class="bg-gray-50 rounded-2xl p-6 hover:bg-gray-100 transition-colors cursor-pointer">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.download_issues') }}</h3>
            <p class="text-gray-600 body-light">{{ __('messages.download_issues_description') }}</p>
        </div>

        <div class="bg-gray-50 rounded-2xl p-6 hover:bg-gray-100 transition-colors cursor-pointer">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.supported_platforms') }}</h3>
            <p class="text-gray-600 body-light">{{ __('messages.supported_platforms_help_description') }}</p>
        </div>

        <div class="bg-gray-50 rounded-2xl p-6 hover:bg-gray-100 transition-colors cursor-pointer">
            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.account_settings') }}</h3>
            <p class="text-gray-600 body-light">{{ __('messages.account_settings_description') }}</p>
        </div>

        <div class="bg-gray-50 rounded-2xl p-6 hover:bg-gray-100 transition-colors cursor-pointer">
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.troubleshooting') }}</h3>
            <p class="text-gray-600 body-light">{{ __('messages.troubleshooting_description') }}</p>
        </div>

        <div class="bg-gray-50 rounded-2xl p-6 hover:bg-gray-100 transition-colors cursor-pointer">
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.api_documentation') }}</h3>
            <p class="text-gray-600 body-light">{{ __('messages.api_documentation_description') }}</p>
        </div>
    </div>

    <!-- Popular Questions -->
    <div>
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center heading-modern">{{ __('messages.popular_questions') }}</h2>
        <div class="space-y-4">
            <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition-shadow">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.how_to_download_video') }}</h3>
                <p class="text-gray-600 body-light">{{ __('messages.how_to_download_video_answer') }}</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition-shadow">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.supported_video_formats') }}</h3>
                <p class="text-gray-600 body-light">{{ __('messages.supported_video_formats_answer') }}</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition-shadow">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.is_service_free') }}</h3>
                <p class="text-gray-600 body-light">{{ __('messages.is_service_free_answer') }}</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-lg transition-shadow">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('messages.download_not_working') }}</h3>
                <p class="text-gray-600 body-light">{{ __('messages.download_not_working_answer') }}</p>
            </div>
        </div>
    </div>
</div>
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