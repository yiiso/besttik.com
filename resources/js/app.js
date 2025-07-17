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
        const platform = data.platform;
        
        let qualityOptionsHtml = '';
        if (videoInfo.quality_options && videoInfo.quality_options.length > 0) {
            qualityOptionsHtml = videoInfo.quality_options.map(option => `
                <div class="bg-white border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-medium text-gray-900">${option.quality} ${option.format.toUpperCase()}</span>
                        <span class="text-sm text-gray-500">${option.size}</span>
                    </div>
                    <button onclick="downloadVideo('${option.download_url}')" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>下载</span>
                    </button>
                </div>
            `).join('');
        }

        let audioOptionsHtml = '';
        if (videoInfo.audio_options && videoInfo.audio_options.length > 0) {
            audioOptionsHtml = videoInfo.audio_options.map(option => `
                <div class="bg-white border border-gray-200 rounded-lg p-4 hover:border-green-300 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-medium text-gray-900">${option.quality} ${option.format.toUpperCase()}</span>
                        <span class="text-sm text-gray-500">${option.size}</span>
                    </div>
                    <button onclick="downloadVideo('${option.download_url}')" 
                            class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition-colors duration-200 flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"/>
                        </svg>
                        <span>下载音频</span>
                    </button>
                </div>
            `).join('');
        }

        parseResults.innerHTML = `
            <div class="bg-white border border-gray-200 rounded-xl p-6 fade-in">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-green-800">解析成功！</h3>
                    <span class="ml-auto px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">${platform.toUpperCase()}</span>
                </div>
                
                <!-- Video Info -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-start space-x-4">
                        <img src="${videoInfo.thumbnail}" alt="视频缩略图" class="w-24 h-18 object-cover rounded-lg">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900 mb-1">${videoInfo.title}</h4>
                            <p class="text-sm text-gray-600">时长: ${videoInfo.duration}</p>
                        </div>
                    </div>
                </div>

                <!-- Video Quality Options -->
                ${qualityOptionsHtml ? `
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        视频下载选项
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        ${qualityOptionsHtml}
                    </div>
                </div>
                ` : ''}

                <!-- Audio Options -->
                ${audioOptionsHtml ? `
                <div>
                    <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z"/>
                        </svg>
                        音频下载选项
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        ${audioOptionsHtml}
                    </div>
                </div>
                ` : ''}
            </div>
        `;
        parseResults.classList.remove('hidden');
    }

    function showError(message) {
        parseResults.innerHTML = `
            <div class="bg-red-50 border border-red-200 rounded-xl p-6 fade-in">
                <div class="flex items-center mb-2">
                    <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-red-800">解析失败</h3>
                </div>
                <p class="text-red-700">${message}</p>
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

// Language switcher functionality
document.addEventListener('DOMContentLoaded', function() {
    const languageSelect = document.querySelector('select');
    if (languageSelect) {
        languageSelect.addEventListener('change', function(e) {
            const selectedLang = e.target.value;
            // Here you would implement language switching logic
            console.log('Language switched to:', selectedLang);
            // For now, just show a message
            if (selectedLang !== 'zh') {
                alert('多语言功能正在开发中，敬请期待！');
                e.target.value = 'zh';
            }
        });
    }
});