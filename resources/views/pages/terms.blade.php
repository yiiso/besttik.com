@extends('pages.layout')

@section('title', __('messages.terms_of_service') . ' - VideoParser.top')
@section('description', 'Terms of Service for VideoParser.top. Read our terms and conditions for using our video parsing service.')

@section('hero-icon')
<div class="w-20 h-20 bg-gradient-to-br from-gray-600 to-gray-800 rounded-3xl flex items-center justify-center mx-auto shadow-xl">
    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
    </svg>
</div>
@endsection

@section('page-title', __('messages.terms_of_service'))

@section('page-description')
{{ __('messages.terms_of_service_description') }}
@endsection

@section('page-content')
<div class="prose prose-lg max-w-none">
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 mb-8">
        <p class="text-amber-800 mb-0"><strong>{{ __('messages.last_updated') }}:</strong> {{ date('F j, Y') }}</p>
    </div>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.acceptance_of_terms') }}</h2>
    <p class="text-gray-600 body-regular mb-6">{{ __('messages.acceptance_of_terms_description') }}</p>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.description_of_service') }}</h2>
    <p class="text-gray-600 body-regular mb-4">{{ __('messages.description_of_service_content') }}</p>
    <ul class="list-disc list-inside text-gray-600 body-light mb-6 space-y-2">
        <li>{{ __('messages.video_link_parsing') }}</li>
        <li>{{ __('messages.multiple_format_support') }}</li>
        <li>{{ __('messages.batch_processing_service') }}</li>
        <li>{{ __('messages.api_access') }}</li>
    </ul>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.user_accounts') }}</h2>
    <p class="text-gray-600 body-regular mb-4">{{ __('messages.user_accounts_description') }}</p>
    <ul class="list-disc list-inside text-gray-600 body-light mb-6 space-y-2">
        <li>{{ __('messages.accurate_information') }}</li>
        <li>{{ __('messages.account_security') }}</li>
        <li>{{ __('messages.account_responsibility') }}</li>
        <li>{{ __('messages.unauthorized_access') }}</li>
    </ul>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.acceptable_use') }}</h2>
    <p class="text-gray-600 body-regular mb-4">{{ __('messages.acceptable_use_description') }}</p>

    <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ __('messages.prohibited_activities') }}</h3>
    <ul class="list-disc list-inside text-gray-600 body-light mb-6 space-y-2">
        <li>{{ __('messages.copyright_infringement') }}</li>
        <li>{{ __('messages.illegal_content') }}</li>
        <li>{{ __('messages.malicious_software') }}</li>
        <li>{{ __('messages.service_disruption') }}</li>
        <li>{{ __('messages.unauthorized_access_attempt') }}</li>
        <li>{{ __('messages.spam_activities') }}</li>
    </ul>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.intellectual_property') }}</h2>
    <p class="text-gray-600 body-regular mb-6">{{ __('messages.intellectual_property_description') }}</p>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.user_content') }}</h2>
    <p class="text-gray-600 body-regular mb-6">{{ __('messages.user_content_description') }}</p>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.service_availability') }}</h2>
    <p class="text-gray-600 body-regular mb-6">{{ __('messages.service_availability_description') }}</p>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.limitation_of_liability') }}</h2>
    <p class="text-gray-600 body-regular mb-6">{{ __('messages.limitation_of_liability_description') }}</p>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.indemnification') }}</h2>
    <p class="text-gray-600 body-regular mb-6">{{ __('messages.indemnification_description') }}</p>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.termination') }}</h2>
    <p class="text-gray-600 body-regular mb-4">{{ __('messages.termination_description') }}</p>
    <ul class="list-disc list-inside text-gray-600 body-light mb-6 space-y-2">
        <li>{{ __('messages.terms_violation') }}</li>
        <li>{{ __('messages.illegal_activities') }}</li>
        <li>{{ __('messages.service_abuse') }}</li>
        <li>{{ __('messages.business_reasons') }}</li>
    </ul>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.governing_law') }}</h2>
    <p class="text-gray-600 body-regular mb-6">{{ __('messages.governing_law_description') }}</p>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.dispute_resolution') }}</h2>
    <p class="text-gray-600 body-regular mb-6">{{ __('messages.dispute_resolution_description') }}</p>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.changes_to_terms') }}</h2>
    <p class="text-gray-600 body-regular mb-6">{{ __('messages.changes_to_terms_description') }}</p>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.severability') }}</h2>
    <p class="text-gray-600 body-regular mb-6">{{ __('messages.severability_description') }}</p>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.entire_agreement') }}</h2>
    <p class="text-gray-600 body-regular mb-6">{{ __('messages.entire_agreement_description') }}</p>

    <h2 class="text-2xl font-bold text-gray-900 mb-4 heading-modern">{{ __('messages.contact_information') }}</h2>
    <p class="text-gray-600 body-regular mb-4">{{ __('messages.terms_contact_description') }}</p>
    <div class="bg-gray-50 rounded-2xl p-6">
        <p class="text-gray-800 font-medium mb-2">VideoParser.top Legal Team</p>
        <p class="text-gray-600">{{ __('messages.email') }}: service@videoparser.top</p>
        <p class="text-gray-600">{{ __('messages.address') }}: [{{ __('messages.company_address') }}]</p>
    </div>
</div>
@endsection
