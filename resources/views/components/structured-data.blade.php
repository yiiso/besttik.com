<!-- FAQ Schema -->

<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "FAQPage",
    "mainEntity": [
        {
            "@@type": "Question",
            "name": "{{ __('messages.how_to_download_video') }}",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "{{ __('messages.how_to_download_video_answer') }}"
            }
        },
        {
            "@@type": "Question",
            "name": "{{ __('messages.supported_video_formats') }}",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "{{ __('messages.supported_video_formats_answer') }}"
            }
        },
        {
            "@@type": "Question",
            "name": "{{ __('messages.is_service_free') }}",
            "acceptedAnswer": {
                "@@type": "Answer",
                "text": "{{ __('messages.is_service_free_answer') }}"
            }
        }
    ]
}
</script>

<!-- HowTo Schema -->
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "HowTo",
    "name": "How to Download Videos from Any Platform",
    "description": "Step-by-step guide to download videos from TikTok, Instagram and other platforms using VideoParser.top",
    "image": "{{ asset('images/how-to-guide.jpg') }}",
    "totalTime": "PT2M",
    "estimatedCost": {
        "@@type": "MonetaryAmount",
        "currency": "USD",
        "value": "0"
    },
    "supply": [
        {
            "@@type": "HowToSupply",
            "name": "Video URL"
        },
        {
            "@@type": "HowToSupply",
            "name": "Internet Connection"
        }
    ],
    "tool": [
        {
            "@@type": "HowToTool",
            "name": "VideoParser.top"
        }
    ],
    "step": [
        {
            "@@type": "HowToStep",
            "name": "Copy Video URL",
            "text": "Copy the video URL from TikTok, Instagram or any supported platform",
            "image": "{{ asset('images/step1.jpg') }}"
        },
        {
            "@@type": "HowToStep",
            "name": "Paste URL",
            "text": "Paste the video URL into the VideoParser.top input field",
            "image": "{{ asset('images/step2.jpg') }}"
        },
        {
            "@@type": "HowToStep",
            "name": "Parse Video",
            "text": "Click the Parse button to analyze the video and get download options",
            "image": "{{ asset('images/step3.jpg') }}"
        },
        {
            "@@type": "HowToStep",
            "name": "Download",
            "text": "Choose your preferred quality and format, then click download",
            "image": "{{ asset('images/step4.jpg') }}"
        }
    ]
}
</script>

<!-- Organization Schema -->
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "Organization",
    "name": "VideoParser.top",
    "url": "https://videoparser.top",
    "logo": "{{ asset('images/logo.png') }}",
    "description": "{{ __('messages.description') }}",
    "foundingDate": "2024",
    "contactPoint": {
        "@@type": "ContactPoint",
        "contactType": "customer service",
        "email": "support@videoparser.top",
        "availableLanguage": ["English", "Chinese", "Spanish", "French", "Japanese"]
    },
    "sameAs": [
        "https://twitter.com/videoparser_top",
        "https://facebook.com/videoparser.top"
    ]
}
</script>

<!-- BreadcrumbList Schema -->
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "https://videoparser.top"
        }
        @if(request()->segment(1) && in_array(request()->segment(1), ['en', 'zh', 'es', 'fr', 'ja']))
        ,{
            "@@type": "ListItem",
            "position": 2,
            "name": "{{ strtoupper(request()->segment(1)) }}",
            "item": "https://videoparser.top/{{ request()->segment(1) }}"
        }
        @endif
        @if(request()->segment(2))
        ,{
            "@@type": "ListItem",
            "position": {{ request()->segment(1) && in_array(request()->segment(1), ['en', 'zh', 'es', 'fr', 'ja']) ? 3 : 2 }},
            "name": "{{ ucfirst(str_replace('-', ' ', request()->segment(2))) }}",
            "item": "{{ url()->current() }}"
        }
        @endif
    ]
}
</script>

