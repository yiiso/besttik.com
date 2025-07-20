@extends('pages.layout')

@section('title', __('messages.contact_us') . ' - VideoParser.top')
@section('description', 'Get in touch with VideoParser.top team. We are here to help you with any questions or support needs.')

@section('hero-icon')
<div class="w-20 h-20 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-3xl flex items-center justify-center mx-auto shadow-xl">
    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
    </svg>
</div>
@endsection

@section('page-title', __('messages.contact_us'))

@section('page-description')
{{ __('messages.contact_us_description') }}
@endsection

@section('page-content')
<div class="space-y-12">
    <!-- Contact Form -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6 heading-modern">{{ __('messages.send_message') }}</h2>
            <form id="contactForm" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.name') ?? 'Name' }}</label>
                    <input type="text" id="name" name="name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.email') }}</label>
                    <input type="email" id="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.subject') }}</label>
                    <select id="subject" name="subject" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                        <option value="">{{ __('messages.select_subject') }}</option>
                        <option value="general">{{ __('messages.general_inquiry') }}</option>
                        <option value="support">{{ __('messages.technical_support') }}</option>
                        <option value="api">{{ __('messages.api_questions') }}</option>
                        <option value="business">{{ __('messages.business_inquiry') }}</option>
                        <option value="bug">{{ __('messages.bug_report') }}</option>
                        <option value="feature">{{ __('messages.feature_request') }}</option>
                    </select>
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.message') }}</label>
                    <textarea id="message" name="message" rows="6" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors resize-none"></textarea>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-semibold transition-colors duration-200 ui-text">
                    {{ __('messages.send_message') }}
                </button>
            </form>
        </div>

        <!-- Contact Information -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6 heading-modern">{{ __('messages.get_in_touch') }}</h2>
            <div class="space-y-6">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ __('messages.email_us') }}</h3>
                        <p class="text-gray-600 body-light">videoparser.top@gmail.com</p>
                        <p class="text-gray-600 body-light">videoparser.top@gmail.com</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ __('messages.response_time') }}</h3>
                        <p class="text-gray-600 body-light">{{ __('messages.response_time_description') }}</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ __('messages.global_support') }}</h3>
                        <p class="text-gray-600 body-light">{{ __('messages.global_support_description') }}</p>
                    </div>
                </div>

                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ __('messages.help_center') }}</h3>
                        <p class="text-gray-600 body-light">{{ __('messages.help_center_link_description') }}</p>
                        <a href="{{ localized_url('/help') }}" class="text-blue-600 hover:text-blue-700 font-medium">{{ __('messages.visit_help_center') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="border-t border-gray-200 pt-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center heading-modern">{{ __('messages.before_contacting') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ __('messages.check_status') }}</h3>
                <p class="text-gray-600 body-light mb-4">{{ __('messages.check_status_description') }}</p>
                <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">{{ __('messages.service_status') }}</a>
            </div>

            <div class="bg-gray-50 rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ __('messages.search_help') }}</h3>
                <p class="text-gray-600 body-light mb-4">{{ __('messages.search_help_description') }}</p>
                <a href="{{ localized_url('/help') }}" class="text-blue-600 hover:text-blue-700 font-medium">{{ __('messages.browse_help') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
