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
        
        // 移除了视频下载选项模块，只保留主要的快速操作按钮

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
                    <div class="flex flex-col lg:flex-row items-start space-y-4 lg:space-y-0 lg:space-x-6">
                        <!-- Video Player -->
                        <div class="w-full lg:w-1/2">
                            <div class="relative bg-black rounded-lg overflow-hidden aspect-video">
                                <video 
                                    id="videoPlayer" 
                                    class="w-full h-full object-contain" 
                                    controls 
                                    poster="${videoInfo.thumbnail}"
                                    preload="metadata"
                                >
                                    ${videoInfo.quality_options && videoInfo.quality_options.length > 0 ? 
                                        `<source src="${videoInfo.quality_options[0].download_url}" type="video/mp4">` : 
                                        ''
                                    }
                                    您的浏览器不支持视频播放。
                                </video>
                                <div class="absolute top-2 right-2">
                                    <button 
                                        onclick="toggleFullscreen()" 
                                        class="bg-black bg-opacity-50 text-white p-2 rounded-lg hover:bg-opacity-70 transition-all"
                                        title="全屏播放"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Video Details -->
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900 mb-2 text-lg">${videoInfo.title}</h4>
                            <div class="space-y-2 text-sm text-gray-600">
                                <p><span class="font-medium">时长:</span> ${videoInfo.duration}</p>
                                <p><span class="font-medium">作者:</span> ${videoInfo.author}</p>
                                <p><span class="font-medium">平台:</span> ${platform.toUpperCase()}</p>
                            </div>
                            
                            <!-- Quick Actions -->
                            <div class="mt-4 flex flex-wrap gap-2">
                                <button 
                                    onclick="playVideo()" 
                                    class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors"
                                >
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m-9-4V8a3 3 0 013-3h6a3 3 0 013 3v2M7 21h10a2 2 0 002-2v-5a2 2 0 00-2-2H7a2 2 0 00-2 2v5a2 2 0 002 2z"/>
                                    </svg>
                                    播放视频
                                </button>
                                <button 
                                    onclick="copyVideoLink('${videoInfo.quality_options && videoInfo.quality_options.length > 0 ? videoInfo.quality_options[0].download_url : ''}')" 
                                    class="inline-flex items-center px-3 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition-colors"
                                >
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                    </svg>
                                    复制链接
                                </button>
                                <button 
                                    onclick="openInNewTab('${videoInfo.quality_options && videoInfo.quality_options.length > 0 ? videoInfo.quality_options[0].download_url : ''}')" 
                                    class="inline-flex items-center px-3 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition-colors"
                                >
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                    新窗口打开
                                </button>
                                <button 
                                    onclick="downloadVideo('${videoInfo.quality_options && videoInfo.quality_options.length > 0 ? videoInfo.quality_options[0].download_url : ''}')" 
                                    class="inline-flex items-center px-3 py-2 bg-orange-600 text-white text-sm rounded-lg hover:bg-orange-700 transition-colors"
                                >
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    下载
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


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