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
            
            // 设置用户手动选择语言的标记cookie（30天有效）
            document.cookie = `user_language_selected=true; max-age=${60 * 60 * 24 * 30}; path=/`;
            document.cookie = `preferred_language=${selectedLang}; max-age=${60 * 60 * 24 * 30}; path=/`;
            
            // 获取当前路径
            const currentPath = window.location.pathname;
            let newPath = '';
            
            // 检查当前路径是否已经包含语言前缀
            const pathParts = currentPath.split('/').filter(part => part !== '');
            const supportedLangs = ['zh', 'en', 'es', 'fr', 'ja'];
            
            // 如果当前路径以支持的语言开头，移除它
            if (pathParts.length > 0 && supportedLangs.includes(pathParts[0])) {
                pathParts.shift(); // 移除语言前缀
            }
            
            // 构建新的路径
            if (selectedLang === 'en') {
                // 英文使用默认路由（不带语言前缀）
                newPath = '/' + pathParts.join('/');
            } else {
                // 其他语言添加语言前缀
                newPath = '/' + selectedLang + '/' + pathParts.join('/');
            }
            
            // 确保路径格式正确
            if (newPath === '/') {
                newPath = selectedLang === 'en' ? '/' : `/${selectedLang}`;
            }
            
            // 跳转到新路径
            window.location.href = newPath;
        });
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
            
            // 直接跳转到Google OAuth，让后端处理配置检查
            setTimeout(() => {
                window.location.href = '/auth/google';
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

    // Google登录按钮功能已在initLoginModal中处理，这里不需要重复

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