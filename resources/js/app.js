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

            // 通过 AJAX 请求设置 cookie，确保与 Laravel 后端兼容
            fetch('/set-language-preference', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    language: selectedLang,
                    user_selected: true
                })
            }).then(() => {
                // Cookie 设置完成后再跳转
                navigateToLanguage(selectedLang);
            }).catch(error => {
                console.error('设置语言偏好失败:', error);
                // 即使设置失败也继续跳转
                navigateToLanguage(selectedLang);
            });
        });
    }

    // 语言跳转逻辑提取为独立函数
    function navigateToLanguage(selectedLang) {
        // 获取当前路径
        const currentPath = window.location.pathname;
        let newPath = '';

        const searchParams = new URLSearchParams(window.location.search);

        searchParams.set('language', selectedLang);

        newPath = `${currentPath}?${searchParams.toString()}`;

        // 跳转到新路径
        window.location.href = newPath;
    }

    // 初始化用户菜单
    initUserMenu();

    // 初始化登录弹窗
    initLoginModal();

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

// 渲染解析结果 - 优化版本
function renderParseResults(videoData, platform) {
    const parseResults = document.getElementById('parseResults');
    if (!parseResults) return;

    // 构建结果HTML
    let html = `
    <div class="bg-white border border-gray-100 rounded-2xl shadow-xl mb-8 overflow-hidden fade-in">
        <!-- 视频播放区域 -->
        <div class="relative bg-black rounded-t-2xl">
            <video
                id="videoPlayer"
                class="w-full aspect-video object-contain rounded-t-2xl"
                referrerpolicy="no-referrer"
                controls
                preload="metadata"
                poster=""
            >
                <source src="${videoData.quality_options[0]?.download_url || ''}" type="video/mp4">
                <p class="text-white text-center py-8">${window.translations?.video_not_supported || '您的浏览器不支持视频播放'}</p>
            </video>

            <!-- 视频加载状态 -->
            <div id="videoLoadingState" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
                <div class="text-white text-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-2 border-white border-t-transparent mx-auto mb-4"></div>
                    <p>${window.translations?.loading_video || '正在加载视频...'}</p>
                </div>
            </div>
        </div>

        <!-- 内容区域 -->
        <div class="p-6 space-y-6">
            <!-- 音频播放器 -->
            ${videoData.audio_options && videoData.audio_options[0] ? `
            <div class="bg-gray-50 rounded-xl p-4">
                <h3 class="text-sm font-medium text-gray-700 mb-3 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 14.142M9 9a3 3 0 000 6h6a3 3 0 000-6H9z" />
                    </svg>
                    ${window.translations?.audio_preview || '音频预览'}
                </h3>
                <audio
                    controls
                    class="w-full h-10"
                    preload="metadata"
                    style="filter: sepia(20%) saturate(70%) grayscale(1) contrast(99%) invert(12%);"
                >
                    <source src="${videoData.audio_options[0].download_url}" type="audio/webm">
                    <source src="${videoData.audio_options[0].download_url}" type="audio/mp3">
                    <p class="text-gray-500 text-sm">${window.translations?.audio_not_supported || '您的浏览器不支持音频播放'}</p>
                </audio>
            </div>
            ` : ''}

            <!-- 操作按钮区域 -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">
                    ${window.translations?.download_options || '下载选项'}
                </h3>

                <!-- 主要操作按钮 -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <button class="download-video-btn btn-primary flex items-center justify-center space-x-2 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-all duration-300 shadow-soft hover:shadow-medium transform hover:-translate-y-0.5" data-url="${videoData.quality_options[0]?.download_url || ''}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span class="font-medium">${window.translations?.download_video || '下载视频'}</span>
                    </button>

                    <button class="copy-link-btn flex items-center justify-center space-x-2 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-all duration-300 shadow-soft hover:shadow-medium transform hover:-translate-y-0.5" data-url="${videoData.quality_options[0]?.download_url || ''}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                        </svg>
                        <span class="font-medium">${window.translations?.copy_link || '复制链接'}</span>
                    </button>

                    <a href="${videoData.quality_options[0]?.download_url || '#'}" target="_blank" rel="noreferrer" class="flex items-center justify-center space-x-2 px-4 py-3 bg-purple-100 hover:bg-purple-200 text-purple-700 rounded-xl transition-all duration-300 shadow-soft hover:shadow-medium transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        <span class="font-medium">${window.translations?.open_new_tab || '新窗口打开'}</span>
                    </a>

                    ${videoData.audio_options && videoData.audio_options[0] ? `
                    <a href="${videoData.audio_options[0].download_url}" download class="flex items-center justify-center space-x-2 px-4 py-3 bg-green-100 hover:bg-green-200 text-green-700 rounded-xl transition-all duration-300 shadow-soft hover:shadow-medium transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 14.142M9 9a3 3 0 000 6h6a3 3 0 000-6H9z" />
                        </svg>
                        <span class="font-medium">${window.translations?.download_audio || '下载音频'}</span>
                    </a>
                    ` : ''}
                </div>

                <!-- 详细下载选项 -->

            </div>

            <!-- 平台信息 -->

        </div>
    </div>
    `;

    // 更新DOM
    parseResults.innerHTML = html;
    parseResults.classList.remove('hidden');

    // 添加事件监听器
    addEventListeners();

    // 初始化视频播放器事件
    initVideoPlayer();
}

// 渲染下载选项 - 优化版本
function renderDownloadOptions(videoData) {
    if (!videoData.quality_options || videoData.quality_options.length === 0) {
        return '';
    }

    let html = `
    <div class="mt-6 border-t border-gray-100 pt-6">
        <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
            </svg>
            ${window.translations?.quality_options || '画质选项'}
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
    `;

    // 视频选项
    videoData.quality_options.forEach((option, index) => {
        const isRecommended = index === 0;
        html += `
        <div class="relative flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 rounded-xl border transition-all duration-200 ${isRecommended ? 'border-blue-200 bg-blue-50' : 'border-gray-200'}">
            ${isRecommended ? `
            <div class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs px-2 py-1 rounded-full">
                ${window.translations?.recommended || '推荐'}
            </div>
            ` : ''}
            <div class="flex-1">
                <div class="flex items-center space-x-2">
                    <span class="font-medium text-gray-800">${option.quality || window.translations?.original_quality || '原画质'}</span>
                    ${isRecommended ? '<span class="text-blue-600 text-sm">★</span>' : ''}
                </div>
                <div class="text-sm text-gray-500 mt-1">
                    <span>${option.format || 'mp4'}</span>
                    ${option.size ? ` · ${option.size}` : ''}
                </div>
            </div>
            <a href="${option.download_url}" download class="ml-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition-colors font-medium">
                ${window.translations?.download || '下载'}
            </a>
        </div>
        `;
    });

    // 音频选项
    if (videoData.audio_options && videoData.audio_options.length > 0) {
        html += `
        </div>
        <h4 class="text-md font-medium text-gray-700 mb-4 mt-6 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 14.142M9 9a3 3 0 000 6h6a3 3 0 000-6H9z" />
            </svg>
            ${window.translations?.audio_options || '音频选项'}
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        `;

        videoData.audio_options.forEach((option, index) => {
            html += `
            <div class="flex items-center justify-between p-4 bg-green-50 hover:bg-green-100 rounded-xl border border-green-200 transition-all duration-200">
                <div class="flex-1">
                    <div class="font-medium text-gray-800">${option.quality || window.translations?.audio_quality || '音质'}</div>
                    <div class="text-sm text-gray-500 mt-1">
                        <span>${option.format || 'mp3'}</span>
                        ${option.size ? ` · ${option.size}` : ''}
                    </div>
                </div>
                <a href="${option.download_url}" download class="ml-4 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg transition-colors font-medium">
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

// 初始化视频播放器事件
function initVideoPlayer() {
    const videoPlayer = document.getElementById('videoPlayer');
    const loadingState = document.getElementById('videoLoadingState');

    if (videoPlayer && loadingState) {
        // 显示加载状态
        videoPlayer.addEventListener('loadstart', function() {
            loadingState.classList.remove('hidden');
        });

        // 隐藏加载状态
        videoPlayer.addEventListener('loadeddata', function() {
            loadingState.classList.add('hidden');
        });

        // 错误处理
        videoPlayer.addEventListener('error', function() {
            loadingState.classList.add('hidden');
            showToast(window.translations?.video_load_error || '视频加载失败', 'error');
        });
    }
}

// 添加事件监听器
function addEventListeners() {
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
            a.rel = 'noreferrer'; // 关键：阻止发送 Referer 头
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        });
    });
}

// 用户菜单功能
function initUserMenu() {
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userDropdown = document.getElementById('userDropdown');
    const logoutBtn = document.getElementById('logoutBtn');

    // 切换用户下拉菜单
    if (userMenuBtn && userDropdown) {
        userMenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('hidden');
        });

        // 点击其他地方关闭下拉菜单
        document.addEventListener('click', function(e) {
            if (!userMenuBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.add('hidden');
            }
        });
    }

    // 退出登录功能
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();

            // 显示确认对话框
            if (confirm(window.translations?.logout_confirm || '确定要退出登录吗？')) {
                // 发送退出登录请求
                fetch('/logout', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        showToast(window.translations?.logout_success || '退出登录成功', 'success');
                        // 刷新页面
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        showToast(data.message || '退出登录失败', 'error');
                    }
                })
                .catch(error => {
                    console.error('Logout error:', error);
                    showToast(window.translations?.network_error || '网络错误，请稍后重试', 'error');
                });
            }
        });
    }
}

// 登录弹窗功能
function initLoginModal() {
    const loginBtn = document.getElementById('loginBtn');
    const loginModal = document.getElementById('loginModal');
    const loginModalContent = document.getElementById('loginModalContent');
    const closeLoginModal = document.getElementById('closeLoginModal');
    const googleLoginBtn = document.getElementById('googleLoginBtn');
    const emailLoginForm = document.getElementById('emailLoginForm');

    // 显示登录弹窗
    if (loginBtn) {
        loginBtn.addEventListener('click', function () {
            loginModal.classList.remove('hidden');
            // 添加动画效果
            setTimeout(() => {
                loginModalContent.classList.remove('scale-95', 'opacity-0');
                loginModalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        });
    }

    // 关闭登录弹窗
    function closeModal() {
        loginModalContent.classList.remove('scale-100', 'opacity-100');
        loginModalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            loginModal.classList.add('hidden');
        }, 300);
    }

    // 点击关闭按钮
    if (closeLoginModal) {
        closeLoginModal.addEventListener('click', closeModal);
    }

    // 点击背景关闭
    if (loginModal) {
        loginModal.addEventListener('click', function (e) {
            if (e.target === loginModal) {
                closeModal();
            }
        });
    }

    // ESC键关闭
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !loginModal.classList.contains('hidden')) {
            closeModal();
        }
    });

    // Google登录
    if (googleLoginBtn) {
        googleLoginBtn.addEventListener('click', function () {
            // 显示加载状态
            this.disabled = true;
            const originalHTML = this.innerHTML;
            this.innerHTML = '<div class="animate-spin rounded-full h-5 w-5 border-2 border-gray-400 border-t-transparent mx-auto"></div>';

            const currentPath = window.location.pathname
            const params = new URLSearchParams({
                target:currentPath
            })
            // 直接跳转到Google OAuth，让后端处理配置检查
            setTimeout(() => {
                window.location.href = `/auth/google?${params}`;
            }, 500); // 短暂延迟显示加载状态
        });
    }

    // 邮箱登录表单提交
    if (emailLoginForm) {
        emailLoginForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(emailLoginForm);
            const email = formData.get('email');
            const password = formData.get('password');

            // 基本验证
            if (!email || !password) {
                showToast('请填写完整的登录信息', 'error');
                return;
            }

            // 发送登录请求
            fetch('/login', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    email: email,
                    password: password
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        showToast(window.translations?.login_success || '登录成功', 'success');
                        closeModal();
                        // 刷新页面或更新UI
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        showToast(data.message || (window.translations?.login_failed || '登录失败'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Login error:', error);
                    showToast(window.translations?.network_error || '网络错误，请稍后重试', 'error');
                });
        });
    }
}

// 扩展登录弹窗功能，添加注册逻辑
document.addEventListener('DOMContentLoaded', function() {
    const showRegisterForm = document.getElementById('showRegisterForm');
    const showLoginForm = document.getElementById('showLoginForm');
    const registerFormContainer = document.getElementById('registerFormContainer');
    const emailLoginForm = document.getElementById('emailLoginForm');
    const emailRegisterForm = document.getElementById('emailRegisterForm');
    const googleLoginBtn = document.getElementById('googleLoginBtn');

    // 显示登录表单
    function showLoginFormView() {
        if (emailLoginForm && emailLoginForm.parentElement) {
            emailLoginForm.parentElement.classList.remove('hidden');
        }
        if (registerFormContainer) {
            registerFormContainer.classList.add('hidden');
        }
        const modalTitle = document.querySelector('#loginModalContent h2');
        if (modalTitle) {
            modalTitle.textContent = window.translations?.login || '登录';
        }
    }

    // 显示注册表单
    function showRegisterFormView() {
        if (emailLoginForm && emailLoginForm.parentElement) {
            emailLoginForm.parentElement.classList.add('hidden');
        }
        if (registerFormContainer) {
            registerFormContainer.classList.remove('hidden');
        }
        const modalTitle = document.querySelector('#loginModalContent h2');
        if (modalTitle) {
            modalTitle.textContent = window.translations?.register || '注册';
        }
    }

    // 切换到注册表单
    if (showRegisterForm) {
        showRegisterForm.addEventListener('click', function(e) {
            e.preventDefault();
            showRegisterFormView();
        });
    }

    // 切换到登录表单
    if (showLoginForm) {
        showLoginForm.addEventListener('click', function(e) {
            e.preventDefault();
            showLoginFormView();
        });
    }

    // 邮箱注册表单提交
    if (emailRegisterForm) {
        emailRegisterForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(emailRegisterForm);
            const email = formData.get('email');
            const password = formData.get('password');
            const passwordConfirmation = formData.get('password_confirmation');

            // 基本验证
            if (!email || !password || !passwordConfirmation) {
                showToast(window.translations?.email_required || '请填写完整的注册信息', 'error');
                return;
            }

            if (password !== passwordConfirmation) {
                showToast(window.translations?.password_confirmation_failed || '两次输入的密码不一致', 'error');
                return;
            }

            if (password.length < 6) {
                showToast(window.translations?.password_min_length || '密码至少需要6位字符', 'error');
                return;
            }

            // 禁用提交按钮
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<div class="animate-spin rounded-full h-5 w-5 border-2 border-white border-t-transparent mx-auto"></div>';

            // 发送注册请求
            fetch('/register', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    email: email,
                    password: password,
                    password_confirmation: passwordConfirmation
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showToast(window.translations?.register_success || '注册成功', 'success');
                    // 关闭弹窗
                    const loginModal = document.getElementById('loginModal');
                    const loginModalContent = document.getElementById('loginModalContent');
                    if (loginModalContent && loginModal) {
                        loginModalContent.classList.remove('scale-100', 'opacity-100');
                        loginModalContent.classList.add('scale-95', 'opacity-0');
                        setTimeout(() => {
                            loginModal.classList.add('hidden');
                            // 重置表单
                            emailRegisterForm.reset();
                        }, 300);
                    }
                    // 刷新页面或更新UI
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showToast(data.message || (window.translations?.register_failed || '注册失败'), 'error');
                }
            })
            .catch(error => {
                console.error('Register error:', error);
                showToast(window.translations?.network_error || '网络错误，请稍后重试', 'error');
            })
            .finally(() => {
                // 恢复提交按钮
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
        });
    }
});
