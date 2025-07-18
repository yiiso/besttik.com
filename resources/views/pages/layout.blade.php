@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-blue-50">
    <!-- Hero Section -->
    <section class="relative overflow-hidden pt-32 pb-20">
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="mb-8">
                @yield('hero-icon')
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 heading-elegant">
                @yield('page-title')
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto body-light">
                @yield('page-description')
            </p>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">
                @yield('page-content')
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    @hasSection('cta-section')
    <section class="py-20 bg-blue-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            @yield('cta-section')
        </div>
    </section>
    @endif
</div>
@endsection