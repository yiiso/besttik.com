// 前台JavaScript文件
import Player from 'xgplayer';
import HlsPlugin from 'xgplayer-hls';
import FlvPlugin from 'xgplayer-flv';

class VideoPlayer {
    constructor() {

        this.playerSection = document.getElementById('player-section');
        this.playerContainer = document.getElementById('xg-player-container');
        this.loading = document.getElementById('loading');
        this.errorMessage = document.getElementById('error-message');
        this.currentUrl = document.getElementById('current-url');
        this.videoFormat = document.getElementById('video-format');
        this.videoStatus = document.getElementById('video-status');
        this.themeToggle = document.getElementById('theme-toggle');
        this.closePlayerBtn = document.getElementById('close-player-btn');
        this.localVideoInput = document.getElementById('local-video-input');

        this.player = null;
        this.currentTheme = localStorage.getItem('theme') || 'light';

        this.init();
    }

    init() {
        this.bindEvents();
        this.setupCSRF();
    }

    setupCSRF() {
        const token = document.querySelector('meta[name="csrf-token"]');
        if (token && window.axios) {
            window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.getAttribute('content');
        }
    }


    bindEvents() {

        // 关闭播放器
        if (this.closePlayerBtn) {
            this.closePlayerBtn.addEventListener('click', () => {
                this.closePlayer();
            });
        }

        // 键盘快捷键
        document.addEventListener('keydown', (e) => {
            if (e.target.tagName.toLowerCase() === 'input') return;

            switch(e.code) {
                case 'Escape':
                    if (this.playerSection && !this.playerSection.classList.contains('hidden')) {
                        this.closePlayer();
                    }
                    break;
                case 'KeyT':
                    if (e.ctrlKey || e.metaKey) {
                        e.preventDefault();
                        this.toggleTheme();
                    }
                    break;
            }
        });
    }


    /**
     * 处理URL协议，将http://或https://统一换成//
     */
    normalizeUrl(url) {
        if (!url) return url;

        // 移除开头和结尾的空白字符
        url = url.trim();

        // 将http://或https://替换为//
        if (url.startsWith('http://')) {
            return url.replace('http://', '//');
        } else if (url.startsWith('https://')) {
            return url.replace('https://', '//');
        }

        // 如果URL没有协议，添加//
        if (!url.startsWith('//') && !url.startsWith('http://') && !url.startsWith('https://')) {
            // 检查是否看起来像一个完整的URL（包含域名）
            if (url.includes('.') && !url.startsWith('/')) {
                return '//' + url;
            }
        }

        return url;
    }

    async playVideo(videoInfo) {
        // 处理URL协议
        url = this.normalizeUrl(videoInfo.url);
        this.hideError();
        this.showLoading();

        try {
            this.loadVideo(url,videoInfo.video_info,videoInfo.quality_options);
        } catch (error) {
            if (error.response && error.response.data && error.response.data.message) {
                this.showError(error.response.data.message);
            } else {
                this.showError('请求失败，请稍后重试');
            }
        } finally {
            this.hideLoading();
        }
    }


    getPluginsForFormat(url, videoInfo) {
        const plugins = [];
        const extension = videoInfo.extension.toLowerCase();

        if (extension === 'm3u8' || url.includes('.m3u8')) {
            plugins.push(HlsPlugin);
        } else if (extension === 'flv' || url.includes('.flv')) {
            plugins.push(FlvPlugin);
        }

        return plugins;
    }

    loadVideo(url, videoInfo, qualityOptions = null) {
        if (this.player) {
            this.player.destroy();
            this.player = null;
        }

        this.showPlayerSection();

        try {
            const plugins = this.getPluginsForFormat(url, videoInfo);
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
            const isMobile = /Mobi|Android|iPhone|iPad|iPod/.test(navigator.userAgent);

            const playerConfig = {
                id: 'xg-player-container',
                url: url,
                // width:'100%',
                fluid:true,
                fitVideoSize: 'auto',
                autoplay: true,
                poster: '',
                pip: true,
                rotate: true,
                playbackRate: [0.5, 0.75, 1, 1.25, 1.5, 2],
                keyShortcut: true,
                flv: { preferMMS: true }, // ios


            };

            if (plugins.length > 0) {
                playerConfig.plugins = plugins;
            }

            if (videoInfo.extension && videoInfo.extension === 'flv' && isIOS) {
                playerConfig.isLive = true;
            }

            if (!isMobile) {
                playerConfig.marginControls = true;
            }

            this.player = new Player(playerConfig);
            this.bindPlayerEvents();

            if (qualityOptions && qualityOptions.length > 1) {
                this.player.once('ready', () => {
                    this.player.emit('resourceReady', qualityOptions);
                });
            }

            this.updateVideoInfo(url, videoInfo);

            if (!videoInfo.is_supported) {
                this.showError('该视频格式可能不被完全支持，播放可能出现问题');
            }
        } catch (error) {
            this.showError('播放器初始化失败: ' + error.message);
        }
    }

    updateVideoInfo(url, videoInfo) {
        if (this.currentUrl) {
            if (videoInfo.is_local) {
                this.currentUrl.textContent = `${videoInfo.file_name} (${videoInfo.file_size})`;
            } else {
                this.currentUrl.textContent = url;
            }
        }

        if (this.videoFormat) {
            this.videoFormat.textContent = videoInfo.extension.toUpperCase() || '未知';
        }

        this.updateStatus('加载中...');
    }

    bindPlayerEvents() {
        if (!this.player) return;

        this.player.on('loadstart', () => this.updateStatus('开始加载'));
        this.player.on('loadedmetadata', () => this.updateStatus('元数据已加载'));
        this.player.on('canplay', () => this.updateStatus('可以播放'));
        this.player.on('playing', () => this.updateStatus('播放中'));
        this.player.on('pause', () => this.updateStatus('已暂停'));
        this.player.on('ended', () => this.updateStatus('播放完成'));
        this.player.on('waiting', () => this.updateStatus('缓冲中...'));
        this.player.on('canplaythrough', () => this.updateStatus('可流畅播放'));
        this.player.on('ready', () => this.updateStatus('准备就绪'));

        this.player.on('error', (error) => {
            this.updateStatus('播放错误');
            console.error('播放器错误:', error);
            this.showError('视频播放失败，请检查视频地址是否正确');
        });
    }

    showPlayerSection() {
        if (this.playerSection) {
            this.playerSection.classList.remove('hidden');
            this.playerSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    }

    closePlayer() {
        if (this.player) {
            const currentUrl = this.player.config.url;
            if (currentUrl && currentUrl.startsWith('blob:')) {
                URL.revokeObjectURL(currentUrl);
            }

            this.player.destroy();
            this.player = null;
        }

        if (this.playerSection) {
            this.playerSection.classList.add('hidden');
        }

        if (this.localVideoInput) {
            this.localVideoInput.value = '';
        }

        if (this.urlInput) {
            this.urlInput.focus();
        }

        window.scrollTo({ top: 0, behavior: 'smooth' });
        this.hideError();
    }

    updateStatus(status) {
        if (this.videoStatus) {
            this.videoStatus.textContent = status;
        }
    }

    showLoading() {
        if (this.loading) {
            this.loading.classList.remove('hidden');
        }
    }

    hideLoading() {
        if (this.loading) {
            this.loading.classList.add('hidden');
        }
    }

    showError(message) {
        if (this.errorMessage) {
            this.errorMessage.textContent = message;
            this.errorMessage.classList.remove('hidden');
            setTimeout(() => {
                this.hideError();
            }, 5000);
        }
    }

    hideError() {
        if (this.errorMessage) {
            this.errorMessage.classList.add('hidden');
        }
    }
}

// 立即设置主题，避免闪烁
(function() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    if (savedTheme === 'dark') {
        document.documentElement.classList.add('dark');
    }
})();

// 页面加载完成后初始化
document.addEventListener('DOMContentLoaded', () => {
    new VideoPlayer();
});
