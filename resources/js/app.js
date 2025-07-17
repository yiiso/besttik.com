import './bootstrap';

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

// Language switcher functionality
document.addEventListener('DOMContentLoaded', function () {
    const languageSelect = document.getElementById('languageSelect');
    if (languageSelect) {
        languageSelect.addEventListener('change', function (e) {
            const selectedLang = e.target.value;
            // 切换语言
            window.location.href = `/${selectedLang}`;
        });
    }

    // 视频解析表单提交
    const videoParseForm = document.getElementById('videoParseForm');
    const parseResults = document.getElementById('parseResults');
    const loadingState = document.getElementById('loadingState');

    if (videoParseForm) {
        videoParseForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // 显示加载状态
            loadingState.classList.remove('hidden');
            parseResults.classList.add('hidden');

            // 获取表单数据
            const formData = new FormData(videoParseForm);
            const videoUrl = formData.get('video_url');

            // 发送AJAX请求
            fetch('/parse', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    video_url: videoUrl
                })
            })
                .then(response => response.json())
                .then(data => {
                    // 隐藏加载状态
                    loadingState.classList.add('hidden');

                    if (data.status === 'success') {
                        // 显示成功消息
                        showToast(window.translations?.parse_success || '解析成功！', 'success');

                        // 渲染解析结果
                        renderParseResults(data.data, data.platform);
                    } else {
                        // 显示错误消息
                        showToast(data.message || (window.translations?.parse_failed || '解析失败'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    loadingState.classList.add('hidden');
                    showToast(window.translations?.network_error || '网络错误，请稍后重试', 'error');
                });
        });
    }
});

// 渲染解析结果
function renderParseResults(videoData, platform) {
    const parseResults = document.getElementById('parseResults');
    if (!parseResults) return;

    // 构建结果HTML
    let html = `
    <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-xl mb-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- 左侧：视频缩略图和播放按钮 -->
            <div class="w-full md:w-1/2 relative group">
                <div class="relative rounded-xl overflow-hidden aspect-video bg-gray-100">
                    <img src="${videoData.thumbnail}" alt="${videoData.title}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <button class="play-video-btn bg-blue-600 hover:bg-blue-700 text-white rounded-full w-16 h-16 flex items-center justify-center shadow-lg transform transition-transform duration-300 hover:scale-110" data-video-url="${videoData.quality_options[0]?.download_url || ''}">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="absolute top-4 right-4 bg-black bg-opacity-70 text-white px-3 py-1 rounded-full text-sm">
                    ${videoData.duration || ''}
                </div>
            </div>
            
            <!-- 右侧：视频信息和操作按钮 -->
            <div class="w-full md:w-1/2">
                <h2 class="text-xl md:text-2xl font-semibold mb-4 line-clamp-2">${videoData.title}</h2>
                
                <div class="flex items-center mb-6">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium">${videoData.author || window.translations?.unknown_author || '未知作者'}</div>
                        <div class="text-sm text-gray-500 capitalize">${platform || ''}</div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <!-- 操作按钮 -->
                    <div class="flex flex-wrap gap-3">
                        <button class="download-video-btn flex items-center space-x-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors" data-url="${videoData.quality_options[0]?.download_url || ''}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <span>${window.translations?.download_video || '下载视频'}</span>
                        </button>
                        
                        <button class="copy-link-btn flex items-center space-x-2 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-colors" data-url="${videoData.quality_options[0]?.download_url || ''}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                            </svg>
                            <span>${window.translations?.copy_link || '复制链接'}</span>
                        </button>
                        
                        <a href="${videoData.quality_options[0]?.download_url || '#'}" target="_blank" class="flex items-center space-x-2 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            <span>${window.translations?.open_new_tab || '新窗口打开'}</span>
                        </a>
                    </div>
                    
                    <!-- 下载选项 -->
                    ${renderDownloadOptions(videoData)}
                </div>
            </div>
        </div>
        
        <!-- 视频播放器 (默认隐藏) -->
        <div id="videoPlayerContainer" class="hidden mt-6">
            <div class="relative aspect-video bg-black rounded-xl overflow-hidden">
                <video id="videoPlayer" class="w-full h-full" controls>
                    <source src="" type="video/mp4">
                    ${window.translations?.browser_not_support || '您的浏览器不支持视频播放'}
                </video>
                <div id="videoPlayerPlaceholder" class="absolute inset-0 flex items-center justify-center bg-gray-900">
                    <div class="text-white text-center">
                        <div class="animate-spin rounded-full h-12 w-12 border-4 border-blue-500 border-t-transparent mx-auto mb-4"></div>
                        <p>${window.translations?.loading_video || '正在加载视频...'}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    `;

    // 更新DOM
    parseResults.innerHTML = html;
    parseResults.classList.remove('hidden');

    // 添加事件监听器
    addEventListeners();
}

// 渲染下载选项
function renderDownloadOptions(videoData) {
    if (!videoData.quality_options || videoData.quality_options.length === 0) {
        return '';
    }

    let html = `
    <div class="mt-6 border-t border-gray-100 pt-4">
        <h3 class="font-medium mb-3">${window.translations?.download_options || '下载选项'}</h3>
        <div class="space-y-2">
    `;

    // 视频选项
    videoData.quality_options.forEach(option => {
        html += `
        <div class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded-lg">
            <div>
                <span class="font-medium">${option.quality || window.translations?.original_quality || '原画质'}</span>
                <span class="text-sm text-gray-500 ml-2">${option.format || 'mp4'} · ${option.size || window.translations?.unknown_size || '未知大小'}</span>
            </div>
            <a href="${option.download_url}" download class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded transition-colors">
                ${window.translations?.download || '下载'}
            </a>
        </div>
        `;
    });

    // 音频选项
    if (videoData.audio_options && videoData.audio_options.length > 0) {
        html += `<h3 class="font-medium mt-4 mb-3">${window.translations?.audio_download_options || '音频下载选项'}</h3>`;

        videoData.audio_options.forEach(option => {
            html += `
            <div class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded-lg">
                <div>
                    <span class="font-medium">${option.quality || window.translations?.audio_quality || '音质'}</span>
                    <span class="text-sm text-gray-500 ml-2">${option.format || 'mp3'} · ${option.size || window.translations?.unknown_size || '未知大小'}</span>
                </div>
                <a href="${option.download_url}" download class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-sm rounded transition-colors">
                    ${window.translations?.download_audio || '下载音频'}
                </a>
            </div>
            `;
        });
    }

    html += `
        </div>
    </div>
    `;

    return html;
}

// 添加事件监听器
function addEventListeners() {
    // 播放视频按钮
    const playButtons = document.querySelectorAll('.play-video-btn');
    playButtons.forEach(button => {
        button.addEventListener('click', function () {
            const videoUrl = this.getAttribute('data-video-url');
            if (!videoUrl) {
                showToast(window.translations?.video_link_unavailable || '视频链接不可用', 'error');
                return;
            }

            const videoPlayerContainer = document.getElementById('videoPlayerContainer');
            const videoPlayer = document.getElementById('videoPlayer');
            const videoSource = videoPlayer.querySelector('source');
            const placeholder = document.getElementById('videoPlayerPlaceholder');

            // 设置视频源
            videoSource.src = videoUrl;
            videoPlayer.load();

            // 显示视频播放器
            videoPlayerContainer.classList.remove('hidden');

            // 滚动到视频播放器
            videoPlayerContainer.scrollIntoView({ behavior: 'smooth' });

            // 视频加载完成后隐藏占位符
            videoPlayer.addEventListener('canplay', function () {
                placeholder.classList.add('hidden');
                videoPlayer.play().catch(err => {
                    console.error('自动播放失败:', err);
                    showToast(window.translations?.play_failed || '自动播放失败，请点击播放按钮', 'info');
                });
            });
        });
    });

    // 复制链接按钮
    const copyButtons = document.querySelectorAll('.copy-link-btn');
    copyButtons.forEach(button => {
        button.addEventListener('click', function () {
            const url = this.getAttribute('data-url');
            if (!url) {
                showToast(window.translations?.video_link_unavailable || '视频链接不可用', 'error');
                return;
            }

            // 复制到剪贴板
            navigator.clipboard.writeText(url)
                .then(() => {
                    showToast(window.translations?.link_copied || '链接已复制到剪贴板！', 'success');
                })
                .catch(err => {
                    console.error('复制失败:', err);
                    showToast(window.translations?.copy_failed || '复制失败，请手动复制链接', 'error');
                });
        });
    });

    // 下载视频按钮
    const downloadButtons = document.querySelectorAll('.download-video-btn');
    downloadButtons.forEach(button => {
        button.addEventListener('click', function () {
            const url = this.getAttribute('data-url');
            if (!url) {
                showToast(window.translations?.video_link_unavailable || '视频链接不可用', 'error');
                return;
            }

            // 创建一个临时链接并点击它来下载
            const a = document.createElement('a');
            a.href = url;
            a.download = 'video.mp4';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        });
    });
}
