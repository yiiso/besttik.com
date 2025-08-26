@extends('layouts.app')

@section('title', 'Best Instagram Video Downloader 2025 - Free Instagram Photo Downloader Online')
@section('description', 'Download Instagram videos and photos online free. Best Instagram downloader 2025 with HD quality support. Fast video downloader for Instagram Reels, Stories, and IGTV. MP4 video downloader online.')
@section('keywords', 'video downloader online,free video downloader,Instagram video downloader,best video downloader 2025,fast video downloader,mp4 video downloader,online video converter,Instagram photo downloader,Instagram Reels downloader,Instagram Stories downloader')

@section('content')
<section class="relative overflow-hidden bg-gradient-to-br from-purple-50 via-white to-pink-50 min-h-screen flex items-start justify-center pt-40">
    <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Best Instagram Video Downloader 2025</span>
            </h1>
            <h2 class="text-xl md:text-2xl text-gray-600 mb-12 max-w-4xl mx-auto leading-relaxed">
                Free Video Downloader Online - Download Instagram Videos, Photos, Reels & Stories - Fast MP4 Video Downloader
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
                            placeholder="Paste Instagram link here - Free video downloader online..."
                            class="w-full px-6 py-4 text-lg bg-white border-2 border-gray-200 focus:border-purple-400 focus:outline-none focus:ring-0 transition-all duration-300 shadow-lg hover:shadow-xl font-sleek rounded-xl"
                            required
                        >
                        <div class="absolute right-2 top-2 bottom-2 flex items-center gap-2">
                            <button type="button" id="pasteBtn" class="p-2 text-gray-500 hover:text-purple-600 transition-all duration-200 cursor-pointer hover:scale-110 flex-shrink-0" title="Paste from clipboard">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                </svg>
                            </button>
                            <button type="submit" class="parse-button bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white transition-all duration-200 flex items-center justify-center cursor-pointer shadow-md hover:shadow-lg ui-text rounded-xl px-4 py-2 flex-shrink-0">
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
                <div class="bg-white border border-gray-100 rounded-2xl p-8 text-center shadow-xl">
                    <div class="flex items-center justify-center space-x-4 mb-4">
                        <div class="animate-spin rounded-full h-10 w-10 border-3 border-purple-600 border-t-transparent"></div>
                        <div class="animate-pulse h-3 bg-purple-200 rounded w-40"></div>
                    </div>
                    <p class="text-gray-600 font-medium text-lg body-regular">Processing Instagram content with our fast video downloader...</p>
                </div>
            </div>

            <!-- Parse Results -->
            <div id="parseResults" class="hidden max-w-6xl mx-auto"></div>
        </div>
    </div>
</section>

<!-- Best Instagram Downloader Features -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl text-gray-900 mb-4">Best Instagram Downloader 2025 Features</h2>
            <p class="text-lg text-gray-600">Professional Instagram content downloader and online video converter service</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
            <div class="text-center group">
                <div class="w-20 h-20 bg-purple-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-purple-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4">Free Instagram Video Downloader</h3>
                <p class="text-gray-600 leading-relaxed">Download Instagram videos in HD quality including Instagram Reels, IGTV, and all video formats with our fast video downloader online.</p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 bg-pink-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-pink-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4">Instagram Photo Downloader Online</h3>
                <p class="text-gray-600 leading-relaxed">Batch download Instagram photos in original quality. Our online video converter preserves Instagram image quality perfectly.</p>
            </div>

            <div class="text-center group">
                <div class="w-20 h-20 bg-indigo-100 rounded-3xl flex items-center justify-center mx-auto mb-6 group-hover:bg-indigo-200 transition-colors duration-200">
                    <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl text-gray-900 mb-4">Instagram Stories Downloader</h3>
                <p class="text-gray-600 leading-relaxed">Save Instagram Stories videos and photos with our best video downloader 2025. Download Instagram Stories content instantly.</p>
            </div>
        </div>
    </div>
</section>

<!-- Supported Instagram Content Types -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl lg:text-4xl text-gray-900 mb-4">Supported Instagram Content - Free Video Downloader</h2>
            <p class="text-lg text-gray-600">Comprehensive Instagram content download support with our MP4 video downloader</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Instagram Reels Downloader</h3>
                <p class="text-sm text-gray-600">Download Instagram Reels with our fast video downloader online</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Instagram Photo Saver</h3>
                <p class="text-sm text-gray-600">Save Instagram HD photos with our best video downloader 2025</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Stories Downloader Free</h3>
                <p class="text-sm text-gray-600">Download Instagram Stories with our online video converter</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V1a1 1 0 011-1h2a1 1 0 011 1v18a1 1 0 01-1 1H4a1 1 0 01-1-1V1a1 1 0 011-1h2a1 1 0 011 1v3"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">IGTV Video Downloader</h3>
                <p class="text-sm text-gray-600">Download Instagram long videos with our MP4 video downloader</p>
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