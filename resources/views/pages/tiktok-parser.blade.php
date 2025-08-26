@extends('layouts.app')

@section('title', 'Best TikTok Video Downloader 2025 - Free Online Video Downloader No Watermark')
@section('description', 'Download TikTok videos online free without watermark. Best TikTok video downloader 2025 with HD quality, fast video downloader, and MP4 video converter. Save TikTok videos instantly.')
@section('keywords', 'video downloader online,free video downloader,TikTok video downloader,best video downloader 2025,fast video downloader,mp4 video downloader,online video converter,TikTok no watermark,download TikTok videos,TikTok downloader free')

@section('content')
<section class="relative overflow-hidden bg-gradient-to-br from-black via-gray-900 to-purple-900 min-h-screen flex items-start justify-center pt-40">
    <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                <span class="bg-gradient-to-r from-pink-400 to-purple-400 bg-clip-text text-transparent">Best TikTok Video Downloader 2025 - Free Online Video Downloader</span>
            </h1>
            <h2 class="text-xl md:text-2xl text-gray-300 mb-12 max-w-4xl mx-auto leading-relaxed">
                Fast Video Downloader - Download TikTok Videos Without Watermark - MP4 Video Downloader Online Free
            </h2>

            <!-- Video Parser Input -->
            <div class="max-w-4xl mx-auto mb-12">
                <form id="videoParseForm" class="relative">
                    @csrf
                    <div class="relative group input-container">
                        <input
                            type="text"
                            id="videoUrl"
                            name="video_url"
                            placeholder="Paste TikTok video link here - Free video downloader online..."
                            class="w-full px-6 py-4 text-lg bg-white border-2 border-gray-200 focus:border-pink-400 focus:outline-none focus:ring-0 transition-all duration-300 shadow-lg hover:shadow-xl font-sleek rounded-xl"
                            required
                        >
                        <div class="absolute right-2 top-2 bottom-2 flex items-center gap-2">
                            <button type="button" id="pasteBtn" class="p-2 text-gray-500 hover:text-pink-600 transition-all duration-200 cursor-pointer hover:scale-110 flex-shrink-0" title="Paste from clipboard">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                </svg>
                            </button>
                            <button type="submit" class="parse-button bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-700 hover:to-purple-700 text-white transition-all duration-200 flex items-center justify-center cursor-pointer shadow-md hover:shadow-lg ui-text rounded-xl px-4 py-2 flex-shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <span class="hidden sm:inline text-xs lg:text-sm font-medium ml-1 whitespace-nowrap">Download Video</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="hidden max-w-3xl mx-auto mb-8">
                <div class="bg-gray-800 border border-gray-700 rounded-2xl p-8 text-center shadow-xl">
                    <div class="flex items-center justify-center space-x-4 mb-4">
                        <div class="animate-spin rounded-full h-10 w-10 border-3 border-pink-600 border-t-transparent"></div>
                        <div class="animate-pulse h-3 bg-pink-200 rounded w-40"></div>
                    </div>
                    <p class="text-gray-300 font-medium text-lg body-regular">Processing video with our fast video downloader...</p>
                </div>
            </div>

            <!-- Parse Results -->
            <div id="parseResults" class="hidden max-w-6xl mx-auto"></div>
        </div>
    </div>
</section>

<!-- Best Video Downloader Features -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl text-gray-900 mb-4">Best Video Downloader 2025 Features</h2>
            <p class="text-lg text-gray-600">Professional online video converter and MP4 video downloader service</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
            <div class="text-center group">
                <div class="w-20 h-20 bg-pink-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-pink-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4">Free Video Downloader No Watermark</h3>
                <p class="text-gray-600 leading-relaxed">Remove watermarks automatically with our advanced online video converter. Download clean, high-quality MP4 videos without any logos or watermarks.</p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 bg-purple-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-purple-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4">Fast Video Downloader Online</h3>
                <p class="text-gray-600 leading-relaxed">Lightning-fast video processing with our best video downloader 2025. No software installation required - download videos online instantly.</p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 bg-indigo-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-indigo-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4">HD MP4 Video Downloader</h3>
                <p class="text-gray-600 leading-relaxed">Download videos in HD quality with our MP4 video downloader. Multiple format support ensures perfect playback on any device.</p>
            </div>
        </div>
    </div>
</section>

<!-- How to Use Video Downloader Online -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl text-gray-900 mb-4">How to Use Our Free Video Downloader</h2>
            <p class="text-lg text-gray-600">Download videos online in 4 simple steps with the best video downloader 2025</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-pink-600">1</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Copy Video Link</h3>
                <p class="text-gray-600 text-sm">Find your favorite video and copy the link from TikTok, Instagram, or any supported platform.</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-purple-600">2</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Paste in Video Downloader Online</h3>
                <p class="text-gray-600 text-sm">Paste the video link into our free video downloader input box above.</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-indigo-600">3</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Click Download Video</h3>
                <p class="text-gray-600 text-sm">Click "Download Video" and our fast video downloader will process your video instantly.</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-blue-600">4</span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Save MP4 Video</h3>
                <p class="text-gray-600 text-sm">Choose your preferred quality and download the MP4 video file to your device.</p>
            </div>
        </div>
    </div>
</section>

<!-- Video Downloader FAQ -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl text-gray-900 mb-4">Video Downloader Online FAQ</h2>
            <p class="text-lg text-gray-600">Common questions about our free video downloader and online video converter</p>
        </div>

        <div class="space-y-8">
            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Is this video downloader online free?</h3>
                <p class="text-gray-600">Yes, our video downloader online is completely free. We offer the best video downloader 2025 experience with no hidden costs. Guest users have daily limits, while registered users enjoy more downloads.</p>
            </div>

            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">How effective is the watermark removal?</h3>
                <p class="text-gray-600">Our advanced online video converter technology removes watermarks while preserving original video quality. Get clean, professional-looking videos with our MP4 video downloader.</p>
            </div>

            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">What video formats does this fast video downloader support?</h3>
                <p class="text-gray-600">Our best video downloader 2025 supports all major video formats including MP4, WebM, and more. Download videos in the format that works best for your device.</p>
            </div>

            <div class="bg-gray-50 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">How fast is this online video converter?</h3>
                <p class="text-gray-600">Our fast video downloader processes most videos within seconds. Advanced technology ensures you get the fastest video downloading experience available online.</p>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pasteBtn = document.getElementById('pasteBtn');
    const videoInput = document.getElementById('videoUrl');

    if (pasteBtn && videoInput) {
        pasteBtn.addEventListener('click', async function() {
            try {
                const text = await navigator.clipboard.readText();
                videoInput.value = text;
                videoInput.focus();
            } catch (err) {
                console.log('Failed to read clipboard:', err);
            }
        });
    }
});
</script>
@endsection
