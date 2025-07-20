@extends('pages.layout')

@section('title', __('messages.privacy_policy') . ' - VideoParser.top')
@section('description', 'Privacy Policy for VideoParser.top. Learn how we collect, use, and protect your personal information.')

@section('hero-icon')
<div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl flex items-center justify-center mx-auto shadow-xl">
    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
    </svg>
</div>
@endsection

@section('page-title', __('messages.privacy_policy'))

@section('page-description')
{{ __('messages.privacy_policy_description') }}
@endsection

@section('page-content')
<div class="prose prose-lg max-w-none">
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 mb-8">
        <p class="text-blue-800 mb-0"><strong>{{ __('messages.last_updated') }}:</strong> {{ date('F j, Y') }}</p>
    </div>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.information_we_collect') }}</h2>
    <p class="text-gray-600 body-regular mb-6">{{ __('messages.information_we_collect_description') }}</p>

    <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ __('messages.personal_information') }}</h3>
    <ul class="list-disc list-inside text-gray-600 body-light mb-6 space-y-2">
        <li>{{ __('messages.email_address_info') }}</li>
        <li>{{ __('messages.name_info') }}</li>
        <li>{{ __('messages.account_preferences') }}</li>
    </ul>

    <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ __('messages.usage_information') }}</h3>
    <ul class="list-disc list-inside text-gray-600 body-light mb-6 space-y-2">
        <li>{{ __('messages.video_urls_processed') }}</li>
        <li>{{ __('messages.ip_address_info') }}</li>
        <li>{{ __('messages.browser_information') }}</li>
        <li>{{ __('messages.usage_patterns') }}</li>
    </ul>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.how_we_use_information') }}</h2>
    <p class="text-gray-600 body-regular mb-4">{{ __('messages.how_we_use_information_description') }}</p>
    <ul class="list-disc list-inside text-gray-600 body-light mb-6 space-y-2">
        <li>{{ __('messages.provide_video_parsing') }}</li>
        <li>{{ __('messages.improve_service_quality') }}</li>
        <li>{{ __('messages.communicate_updates') }}</li>
        <li>{{ __('messages.prevent_abuse') }}</li>
        <li>{{ __('messages.comply_legal_requirements') }}</li>
    </ul>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.information_sharing') }}</h2>
    <p class="text-gray-600 body-regular mb-4">{{ __('messages.information_sharing_description') }}</p>
    <ul class="list-disc list-inside text-gray-600 body-light mb-6 space-y-2">
        <li>{{ __('messages.service_providers') }}</li>
        <li>{{ __('messages.legal_compliance') }}</li>
        <li>{{ __('messages.business_transfers') }}</li>
        <li>{{ __('messages.consent_sharing') }}</li>
    </ul>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.data_security') }}</h2>
    <p class="text-gray-600 body-regular mb-6">{{ __('messages.data_security_description') }}</p>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.data_retention') }}</h2>
    <p class="text-gray-600 body-regular mb-6">{{ __('messages.data_retention_description') }}</p>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.your_rights') }}</h2>
    <p class="text-gray-600 body-regular mb-4">{{ __('messages.your_rights_description') }}</p>
    <ul class="list-disc list-inside text-gray-600 body-light mb-6 space-y-2">
        <li>{{ __('messages.access_personal_data') }}</li>
        <li>{{ __('messages.correct_inaccurate_data') }}</li>
        <li>{{ __('messages.delete_personal_data') }}</li>
        <li>{{ __('messages.restrict_processing') }}</li>
        <li>{{ __('messages.data_portability') }}</li>
        <li>{{ __('messages.withdraw_consent') }}</li>
    </ul>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.cookies_tracking') }}</h2>
    <p class="text-gray-600 body-regular mb-6">{{ __('messages.cookies_tracking_description') }}</p>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.third_party_links') }}</h2>
    <p class="text-gray-600 body-regular mb-6">{{ __('messages.third_party_links_description') }}</p>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.children_privacy') }}</h2>
    <p class="text-gray-600 body-regular mb-6">{{ __('messages.children_privacy_description') }}</p>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.international_transfers') }}</h2>
    <p class="text-gray-600 body-regular mb-6">{{ __('messages.international_transfers_description') }}</p>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.policy_changes') }}</h2>
    <p class="text-gray-600 body-regular mb-6">{{ __('messages.policy_changes_description') }}</p>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.contact_information') }}</h2>
    <p class="text-gray-600 body-regular mb-4">{{ __('messages.privacy_contact_description') }}</p>
    <div class="bg-gray-50 rounded-2xl p-6">
        <p class="text-gray-800 font-medium mb-2">VideoParser.top Privacy Team</p>
        <p class="text-gray-600">{{ __('messages.email') }}: videoparser.top@gmail.com</p>
        <p class="text-gray-600">{{ __('messages.address') }}: [{{ __('messages.company_address') }}]</p>
    </div>
</div>
@endsection
