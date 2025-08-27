// XGPlayer 播放器工具类
import Player from 'xgplayer';
import HlsPlugin from 'xgplayer-hls';
import FlvPlugin from 'xgplayer-flv';

class XGPlayerHelper {
    constructor() {
        this.player = null;
    }


    /**
     * 创建 XGPlayer 实例
     */
    createPlayer(container, videoUrl, poster = '', options = {}) {
        // 销毁之前的播放器实例
        if (this.player) {
            this.player.destroy();
            this.player = null;
        }

        try {
            // 检测视频格式
            const isFlv = videoUrl.includes('.flv') || videoUrl.includes('flv=1') || videoUrl.includes('format=flv');
            const isM3u8 = videoUrl.includes('.m3u8') || videoUrl.includes('m3u8') || videoUrl.includes('.ts');

            // 配置插件
            const plugins = [];
            if (isM3u8) {
                plugins.push(HlsPlugin);
            } else if (isFlv) {
                plugins.push(FlvPlugin);
            }

            // 默认播放器配置
            const defaultConfig = {
                id: container,
                url: videoUrl,
                fluid: true,
                fitVideoSize: 'auto',
                autoplay: true,
                poster: poster || '',
                pip: true,
                rotate: true,
                playbackRate: [0.5, 0.75, 1, 1.25, 1.5, 2],
                keyShortcut: true,
                lang: 'en'
            };

            // 合并用户配置
            const playerConfig = { ...defaultConfig, ...options };

            // 添加插件
            if (plugins.length > 0) {
                playerConfig.plugins = plugins;
            }

            // 移动端优化
            const isMobile = /Mobi|Android|iPhone|iPad|iPod/.test(navigator.userAgent);
            if (!isMobile) {
                playerConfig.marginControls = true;
            }

            // 创建播放器
            this.player = new Player(playerConfig);

            return this.player;

        } catch (error) {
            console.error('XGPlayer 创建失败:', error);
            throw error;
        }
    }


    /**
     * 销毁播放器
     */
    destroy() {
        if (this.player) {
            this.player.destroy();
            this.player = null;
        }
    }

    /**
     * 绑定播放器事件
     */
    bindEvents(player, callbacks = {}) {
        if (!player) return;

        // 默认事件回调
        const defaultCallbacks = {
            onReady: () => console.log('XGPlayer 准备就绪'),
            onPlaying: () => console.log('视频播放中'),
            onPause: () => console.log('视频已暂停'),
            onEnded: () => console.log('视频播放结束'),
            onError: (error) => {
                console.error('XGPlayer 播放错误:', error);
                if (window.showToast) {
                    window.showToast('视频播放失败，请检查视频地址或尝试直接下载', 'error');
                }
            }
        };

        // 合并回调函数
        const finalCallbacks = { ...defaultCallbacks, ...callbacks };

        // 绑定事件
        player.on('ready', finalCallbacks.onReady);
        player.on('playing', finalCallbacks.onPlaying);
        player.on('pause', finalCallbacks.onPause);
        player.on('ended', finalCallbacks.onEnded);
        player.on('error', finalCallbacks.onError);

        // 其他常用事件
        player.on('loadstart', () => console.log('开始加载视频'));
        player.on('canplay', () => console.log('视频可以播放'));
        player.on('waiting', () => console.log('视频缓冲中...'));
    }
}

// 导出全局实例
window.XGPlayerHelper = XGPlayerHelper;
