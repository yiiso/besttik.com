<!-- FAQ Section for SEO -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl text-gray-900 mb-4 heading-elegant">{{ __('messages.frequently_asked_questions') }}</h2>
            <p class="text-lg text-gray-600 body-light">{{ __('messages.faq_subtitle') }}</p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="space-y-6">
                <!-- FAQ Item 1 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <button class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none" onclick="toggleFAQ(1)">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('messages.how_to_download_video') }}</h3>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform" id="faq-icon-1">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4" id="faq-content-1">
                        <p class="text-gray-600">{{ __('messages.how_to_download_video_answer') }}</p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <button class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none" onclick="toggleFAQ(2)">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('messages.supported_video_formats') }}</h3>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform" id="faq-icon-2">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4" id="faq-content-2">
                        <p class="text-gray-600">{{ __('messages.supported_video_formats_answer') }}</p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <button class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none" onclick="toggleFAQ(3)">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('messages.is_service_free') }}</h3>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform" id="faq-icon-3">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4" id="faq-content-3">
                        <p class="text-gray-600">{{ __('messages.is_service_free_answer') }}</p>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <button class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none" onclick="toggleFAQ(4)">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('messages.download_not_working') }}</h3>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform" id="faq-icon-4">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4" id="faq-content-4">
                        <p class="text-gray-600">{{ __('messages.download_not_working_answer') }}</p>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <button class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none" onclick="toggleFAQ(5)">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('messages.supported_platforms_question') }}</h3>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform" id="faq-icon-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4" id="faq-content-5">
                        <p class="text-gray-600">{{ __('messages.supported_platforms_answer') }}</p>
                    </div>
                </div>

                <!-- FAQ Item 6 -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <button class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none" onclick="toggleFAQ(6)">
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('messages.video_quality_question') }}</h3>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform" id="faq-icon-6">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4" id="faq-content-6">
                        <p class="text-gray-600">{{ __('messages.video_quality_answer') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function toggleFAQ(index) {
    const content = document.getElementById(`faq-content-${index}`);
    const icon = document.getElementById(`faq-icon-${index}`);
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}
</script>