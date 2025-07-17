import './bootstrap';

// Video Parser functionality
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('videoParseForm');
    const loadingState = document.getElementById('loadingState');
    const parseResults = document.getElementById('parseResults');
    const videoUrlInput = document.getElementById('videoUrl');

    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const videoUrl = videoUrlInput.value.trim();
            if (!videoUrl) {
                showError('请输入有效的视频链接');
                return;
            }

            // Show loading state
            loadingState.classList.remove('hidden');
            parseResults.classList.add('hidden');

            try {
                const response = await fetch('/parse', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ video_url: videoUrl })
                });

                const data = await response.json();
                
                // Hide loading state
                loadingState.classList.add('hidden');
                
                if (data.status === 'success') {
                    showResults(data);
                } else {
                    showError(data.message || '解析失败，请检查链接是否正确');
                }
            } catch (error) {
                loadingState.classList.add('hidden');
                showError('网络错误，请稍后重试');
                console.error('Parse error:', error);
            }
        });
    }

    function showResults(data) {
        const videoInfo = data.data;
        const platform = data.platform || 'unknown';
        
        // Get translations from global window object (will be set by Laravel)
        const t = window.translations || {};
        
        parseResults.innerHTML = `
            <div class="bg-white border border-gray-100 rounded-3xl shadow-strong p-8 fade-in font-elegant overflow-hidden">
                <!-- Success Header with Animated Background -->
                <div class="relative mb-8 pb-6 border-b border-gray-100">
                    <div class="absolute inset-0 bg-gradient-to-r from-green-50 via-emerald-50 to-teal-50 rounded-2xl opacity-60"></div>
                    <div class="relative flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-green-500 via-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center mr-6 shadow-strong animate-pulse">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 heading-elegant mb-1">${t.parse_success || '解析成功！'}</h3>
                                <p class="text-sm text-gray-600 body-light">${t.video_info || '视频信息已成功获取'}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm font-medium rounded-full shadow-medium ui-text">
                                ${platform.toUpperCase()}
                            </span>
                            <div class="w-3 h-3 bg-green-500 rounded-full animate-ping"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 xl:grid-cols-5 gap-8">
                    <!-- Video Player Section -->
                    <div class="xl:col-span-3">
                        <div class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-black rounded-3xl overflow-hidden shadow-strong">
                            <!-- Video Container -->
                            <div class="relative aspect-video">
                                <video 
                                    id="videoPlayer" 
                                    class="w-full h-full object-contain bg-black" 
                                    controls 
                                    poster="${videoInfo.thumbnail}"
                                    preload="metadata"
                                    controlsList="nodownload"
                                >
                                    ${videoInfo.quality_options && videoInfo.quality_options.length > 0 ? 
                                        `<source src="${videoInfo.quality_options[0].download_url}" type="video/mp4">` : 
                                        ''
                                    }
                                    <div class="absolute inset-0 flex items-center justify-center bg-gray-900">
                                        <p class="text-white body-light">${t.video_unavailable || '您的浏览器不支持视频播放'}</p>
                                    </div>
                                </video>
                                
                                <!-- Custom Controls Overlay -->
                                <div class="absolute top-4 right-4 flex space-x-2">
                                    <button 
                                        onclick="toggleFullscreen()" 
                                        class="bg-black bg-opacity-70 backdrop-blur-sm text-white p-3 rounded-xl hover:bg-opacity-90 transition-all duration-200 shadow-medium ui-text group"
                                        title="${t.fullscreen || '全屏播放'}"
                                    >
                                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                        </svg>
                                    </button>
                                </div>
                                
                                <!-- Loading Overlay -->
                                <div id="videoLoadingOverlay" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
                                    <div class="text-center text-white">
                                        <div class="animate-spin rounded-full h-12 w-12 border-3 border-white border-t-transparent mx-auto mb-4"></div>
                                        <p class="body-light">${t.parsing_video || '正在加载视频...'}</p>
                                    </div>
                                </div>
                                
                                <!-- Error Overlay -->
                                <div id="videoErrorOverlay" class="hidden absolute inset-0 bg-gradient-to-br from-gray-900 to-black flex items-center justify-center">
                                    <div class="text-center text-white p-8 max-w-md">
                                        <div class="w-20 h-20 bg-red-500 bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-6">
                                            <svg class="w-10 h-10 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <h4 class="text-xl font-bold mb-3 heading-modern">${t.video_unavailable || '视频无法播放'}</h4>
                                        <p class="text-sm text-gray-300 mb-8 body-light leading-relaxed">${t.video_error_desc || '可能是由于防盗链保护，请尝试以下方式：'}</p>
                                        <div class="space-y-3">
                                            <button onclick="openInNewTab('${videoInfo.quality_options && videoInfo.quality_options.length > 0 ? videoInfo.quality_options[0].download_url : ''}')" 
                                                class="block w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-xl transition-all duration-200 shadow-medium ui-text">
                                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                </svg>
                                                ${t.open_in_new_window || '在新窗口中打开'}
                                            </button>
                                            <button onclick="copyVideoLink('${videoInfo.quality_options && videoInfo.quality_options.length > 0 ? videoInfo.quality_options[0].download_url : ''}')" 
                                                class="block w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-3 rounded-xl transition-all duration-200 shadow-medium ui-text">
                                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                                ${t.copy_video_link || '复制视频链接'}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Video Information Panel -->
                    <div class="xl:col-span-2 space-y-6">
                        <!-- Video Details Card -->
                        <div class="bg-gradient-to-br from-gray-50 via-white to-gray-50 rounded-3xl p-6 shadow-medium border border-gray-100">
                            <div class="flex items-start justify-between mb-4">
                                <h4 class="font-bold text-gray-900 text-lg leading-tight heading-modern pr-4 line-clamp-3">
                                    ${videoInfo.title || t.unknown_title || '未知标题'}
                                </h4>
                                <button onclick="shareVideo('${videoInfo.quality_options && videoInfo.quality_options.length > 0 ? videoInfo.quality_options[0].download_url : ''}')" 
                                    class="flex-shrink-0 p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200"
                                    title="${t.share || '分享'}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"/>
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="space-y-4 text-sm">
                                <div class="flex items-center text-gray-600 body-light">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">${t.duration || '时长'}</span>
                                        <p class="text-gray-600">${videoInfo.duration || t.unknown_duration || '未知时长'}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center text-gray-600 body-light">
                                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">${t.author || '作者'}</span>
                                        <p class="text-gray-600 truncate">${videoInfo.author || t.unknown_author || '未知作者'}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center text-gray-600 body-light">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-700">${t.platform || '平台'}</span>
                                        <p class="text-gray-600">${platform.charAt(0).toUpperCase() + platform.slice(1)}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quick Actions Card -->
                        <div class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 rounded-3xl p-6 shadow-medium border border-blue-100">
                            <h5 class="text-lg font-bold text-gray-800 mb-4 heading-modern flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                ${t.quick_actions || '快速操作'}
                            </h5>
                            <div class="grid grid-cols-2 gap-3">
                                <button 
                                    onclick="playVideo()" 
                                    class="group flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-medium ui-text"
                                >
                                    <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m-9-4V8a3 3 0 013-3h6a3 3 0 013 3v2M7 21h10a2 2 0 002-2v-5a2 2 0 00-2-2H7a2 2 0 00-2 2v5a2 2 0 002 2z"/>
                                    </svg>
                                    ${t.play_video || '播放'}
                                </button>
                                
                                <button 
                                    onclick="copyVideoLink('${videoInfo.quality_options && videoInfo.quality_options.length > 0 ? videoInfo.quality_options[0].download_url : ''}')" 
                                    class="group flex items-center justify-center px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-medium ui-text"
                                >
                                    <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    ${t.copy_link || '复制'}
                                </button>
                                
                                <button 
                                    onclick="openInNewTab('${videoInfo.quality_options && videoInfo.quality_options.length > 0 ? videoInfo.quality_options[0].download_url : ''}')" 
                                    class="group flex items-center justify-center px-4 py-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-medium ui-text"
                                >
                                    <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                    ${t.open_new_tab || '新窗口'}
                                </button>
                                
                                <button 
                                    onclick="downloadVideo('${videoInfo.quality_options && videoInfo.quality_options.length > 0 ? videoInfo.quality_options[0].download_url : ''}')" 
                                    class="group flex items-center justify-center px-4 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white text-sm font-medium rounded-xl transition-all duration-200 shadow-medium ui-text"
                                >
                                    <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    ${t.download || '下载'}
                                </button>
                            </div>
                        </div>
                        
                        <!-- Download Options Card -->
                        ${videoInfo.quality_options && videoInfo.quality_options.length > 0 ? `
                        <div class="bg-gradient-to-br from-orange-50 via-white to-red-50 rounded-3xl p-6 shadow-medium border border-orange-100">
                            <h5 class="text-lg font-bold text-gray-800 mb-4 heading-modern flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                ${t.video_download_options || '下载选项'}
                            </h5>
                            <div class="space-y-3">
                                ${videoInfo.quality_options.map((option, index) => `
                                    <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-gray-200 hover:border-orange-300 hover:shadow-soft transition-all duration-200">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 body-regular">${option.quality || t.original_quality || '原画质'}</p>
                                                <p class="text-sm text-gray-500 body-light">${option.format || 'MP4'} • ${option.size || t.unknown_size || '未知大小'}</p>
                                            </div>
                                        </div>
                                        <button 
                                            onclick="downloadVideo('${option.download_url}')" 
                                            class="px-4 py-2 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-soft ui-text"
                                        >
                                            ${t.download || '下载'}
                                        </button>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        ` : ''}
                        
                        <!-- Audio Options Card -->
                        ${videoInfo.audio_options && videoInfo.audio_options.length > 0 ? `
                        <div class="bg-gradient-to-br from-green-50 via-white to-emerald-50 rounded-3xl p-6 shadow-medium border border-green-100">
                            <h5 class="text-lg font-bold text-gray-800 mb-4 heading-modern flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
                                </svg>
                                ${t.audio_download_options || '音频下载'}
                            </h5>
                            <div class="space-y-3">
                                ${videoInfo.audio_options.map((option, index) => `
                                    <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-gray-200 hover:border-green-300 hover:shadow-soft transition-all duration-200">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 body-regular">${option.quality || '原音质'}</p>
                                                <p class="text-sm text-gray-500 body-light">${option.format || 'MP3'} • ${option.size || t.unknown_size || '未知大小'}</p>
                                            </div>
                                        </div>
                                        <button 
                                            onclick="downloadVideo('${option.download_url}')" 
                                            class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-soft ui-text"
                                        >
                                            ${t.download_audio || '下载'}
                                        </button>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        ` : ''}
                    </div>
                </div>
            </div>
        `;
        
        parseResults.classList.remove('hidden');
        
        // Smooth scroll to results
        parseResults.scrollIntoView({ behavior: 'smooth', block: 'start' });
        
        // Add video error handling
        const video = document.getElementById('videoPlayer');
        if (video) {
            video.addEventListener('error', function() {
                document.getElementById('videoErrorOverlay').classList.remove('hidden');
            });
            
            video.addEventListener('loadstart', function() {
                document.getElementById('videoLoadingOverlay').classList.remove('hidden');
            });
            
            video.addEventListener('canplay', function() {
                document.getElementById('videoLoadingOverlay').classList.add('hidden');
            });
        }
    }

    function showError(message) {
        const t = window.translations || {};
        
        parseResults.innerHTML = `
            <div class="bg-gradient-to-br from-red-50 to-red-100 border border-red-200 rounded-2xl p-8 fade-in shadow-soft font-elegant">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center mr-4 shadow-medium">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-red-800 heading-modern">${t.parse_failed || '解析失败'}</h3>
                        <p class="text-sm text-red-600 body-light mt-1">${t.network_error || '请检查链接或稍后重试'}</p>
                    </div>
                </div>
                <div class="bg-white bg-opacity-60 rounded-xl p-4">
                    <p class="text-red-700 body-regular">${message}</p>
                </div>
            </div>
        `;
        parseResults.classList.remove('hidden');
    }

    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Auto-focus on video URL input when CTA button is clicked
    const ctaButton = document.querySelector('a[onclick*="videoUrl"]');
    if (ctaButton) {
        ctaButton.addEventListener('click', function(e) {
            e.preventDefault();
            videoUrlInput.focus();
            videoUrlInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    }
});
// Global download function
window.downloadVideo = function(downloadUrl) {
    if (downloadUrl === '#') {
        alert('下载功能正在开发中，敬请期待！');
        return;
    }
    
    // Create a temporary link element and trigger download
    const link = document.createElement('a');
    link.href = downloadUrl;
    link.download = '';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
};

// Video player functions
window.playVideo = function() {
    const video = document.getElementById('videoPlayer');
    if (video) {
        if (video.paused) {
            video.play();
        } else {
            video.pause();
        }
    }
};

window.toggleFullscreen = function() {
    const video = document.getElementById('videoPlayer');
    if (video) {
        if (video.requestFullscreen) {
            video.requestFullscreen();
        } else if (video.webkitRequestFullscreen) {
            video.webkitRequestFullscreen();
        } else if (video.msRequestFullscreen) {
            video.msRequestFullscreen();
        }
    }
};

window.shareVideo = function(videoUrl) {
    if (navigator.share) {
        navigator.share({
            title: '视频分享',
            text: '查看这个视频',
            url: videoUrl
        }).catch(console.error);
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(videoUrl).then(() => {
            alert('视频链接已复制到剪贴板！');
        }).catch(() => {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = videoUrl;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            alert('视频链接已复制到剪贴板！');
        });
    }
};

// Video quality switcher
window.switchVideoQuality = function(videoUrl, quality) {
    const video = document.getElementById('videoPlayer');
    if (video) {
        const currentTime = video.currentTime;
        const wasPlaying = !video.paused;
        
        video.src = videoUrl;
        video.load();
        
        video.addEventListener('loadedmetadata', function() {
            video.currentTime = currentTime;
            if (wasPlaying) {
                video.play();
            }
        }, { once: true });
        
        // Update quality indicator
        document.querySelectorAll('.quality-btn').forEach(btn => {
            btn.classList.remove('bg-blue-600', 'text-white');
            btn.classList.add('bg-gray-200', 'text-gray-700');
        });
        
        const activeBtn = document.querySelector(`[data-quality="${quality}"]`);
        if (activeBtn) {
            activeBtn.classList.remove('bg-gray-200', 'text-gray-700');
            activeBtn.classList.add('bg-blue-600', 'text-white');
        }
    }
};

// Language switcher functionality
document.addEventListener('DOMContentLoaded', function() {
    const languageSelect = document.getElementById('languageSelect');
    if (languageSelect) {
        languageSelect.addEventListener('change', function(e) {
            const selectedLang = e.target.value;
            // 切换语言
            window.location.href = `/${selectedLang}`;
        });
    }
});

// Video player functions
window.playVideo = function() {
    const video = document.getElementById('videoPlayer');
    if (video) {
        if (video.paused) {
            video.play();
        } else {
            video.pause();
        }
    }
};

window.toggleFullscreen = function() {
    const video = document.getElementById('videoPlayer');
    if (video) {
        if (video.requestFullscreen) {
            video.requestFullscreen();
        } else if (video.webkitRequestFullscreen) {
            video.webkitRequestFullscreen();
        } else if (video.msRequestFullscreen) {
            video.msRequestFullscreen();
        }
    }
};

window.shareVideo = function(videoUrl) {
    if (navigator.share) {
        navigator.share({
            title: '视频分享',
            text: '查看这个视频',
            url: videoUrl
        }).catch(console.error);
    } else {
        // 复制到剪贴板
        navigator.clipboard.writeText(videoUrl).then(() => {
            alert('链接已复制到剪贴板！');
        }).catch(() => {
            // 备用方案
            const textArea = document.createElement('textarea');
            textArea.value = videoUrl;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            alert('链接已复制到剪贴板！');
        });
    }
};

// Video quality switcher
window.switchVideoQuality = function(videoUrl) {
    const video = document.getElementById('videoPlayer');
    if (video) {
        const currentTime = video.currentTime;
        const wasPlaying = !video.paused;
        
        video.src = videoUrl;
        video.currentTime = currentTime;
        
        if (wasPlaying) {
            video.play();
        }
    }
};

// Copy video link function
window.copyVideoLink = function(videoUrl) {
    if (!videoUrl || videoUrl === '#') {
        alert('视频链接不可用');
        return;
    }
    
    navigator.clipboard.writeText(videoUrl).then(() => {
        // 显示成功提示
        showToast('视频链接已复制到剪贴板！', 'success');
    }).catch(() => {
        // 备用方案
        const textArea = document.createElement('textarea');
        textArea.value = videoUrl;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        textArea.style.top = '-999999px';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            document.execCommand('copy');
            showToast('视频链接已复制到剪贴板！', 'success');
        } catch (err) {
            showToast('复制失败，请手动复制链接', 'error');
        }
        
        document.body.removeChild(textArea);
    });
};

// Open video in new tab function
window.openInNewTab = function(videoUrl) {
    if (!videoUrl || videoUrl === '#') {
        alert('视频链接不可用');
        return;
    }
    
    window.open(videoUrl, '_blank', 'noopener,noreferrer');
};

// Toast notification function
function showToast(message, type = 'info') {
    // Remove existing toast
    const existingToast = document.getElementById('toast');
    if (existingToast) {
        existingToast.remove();
    }
    
    // Create toast element
    const toast = document.createElement('div');
    toast.id = 'toast';
    toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium transition-all duration-300 transform translate-x-full`;
    
    // Set color based on type
    if (type === 'success') {
        toast.className += ' bg-green-600';
    } else if (type === 'error') {
        toast.className += ' bg-red-600';
    } else {
        toast.className += ' bg-blue-600';
    }
    
    toast.textContent = message;
    document.body.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }, 3000);
}

// Enhanced video player with error handling
window.playVideoWithFallback = function() {
    const video = document.getElementById('videoPlayer');
    if (!video) return;
    
    // Add error event listener
    video.addEventListener('error', function(e) {
        console.error('Video playback error:', e);
        showToast('视频播放失败，请尝试在新窗口中打开', 'error');
        
        // Show fallback options
        const videoContainer = video.parentElement;
        const fallbackDiv = document.createElement('div');
        fallbackDiv.className = 'absolute inset-0 bg-black bg-opacity-75 flex items-center justify-center';
        fallbackDiv.innerHTML = `
            <div class="text-center text-white p-6">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-lg font-semibold mb-2">视频无法播放</h3>
                <p class="text-sm text-gray-300 mb-4">可能是由于防盗链保护，请尝试以下方式：</p>
                <div class="space-y-2">
                    <button onclick="openInNewTab('${video.src}')" class="block w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        在新窗口中打开
                    </button>
                    <button onclick="copyVideoLink('${video.src}')" class="block w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                        复制视频链接
                    </button>
                </div>
            </div>
        `;
        videoContainer.appendChild(fallbackDiv);
    });
    
    // Try to play
    if (video.paused) {
        video.play().catch(error => {
            console.error('Play failed:', error);
            showToast('自动播放失败，请点击播放按钮', 'error');
        });
    } else {
        video.pause();
    }
};

// Update the original playVideo function to use the enhanced version
window.playVideo = window.playVideoWithFallback;

// Video player event listeners
document.addEventListener('DOMContentLoaded', function() {
    // 监听视频播放器事件
    document.addEventListener('click', function(e) {
        if (e.target.id === 'videoPlayer') {
            const video = e.target;
            if (video.paused) {
                video.play().catch(error => {
                    console.error('Play failed:', error);
                });
            } else {
                video.pause();
            }
        }
    });
});