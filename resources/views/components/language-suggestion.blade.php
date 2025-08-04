{{-- 语言建议提示组件 --}}
<div id="languageSuggestion" class="hidden fixed right-8 top-6 z-40 max-w-md w-full" style="left:auto;transform:none;">
    <div class="bg-white border border-blue-200 rounded-lg shadow-xl p-4 backdrop-blur-sm bg-white/95">
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900" id="suggestionText">
                    <!-- 动态内容将通过 JavaScript 填充 -->
                </p>
                <div class="mt-3 justify-center flex space-x-2">
                    <button id="acceptLanguage" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <!-- 按钮文本将通过 JavaScript 填充 -->
                    </button>
                    <button id="dismissSuggestion" class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        {{ __('messages.dismiss') }}
                    </button>
                </div>
            </div>
            <div class="flex-shrink-0">
                <button id="closeSuggestion" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 语言配置
    const supportedLanguages = {
        'en': { name: 'English', code: 'en' },
        'zh': { name: '中文', code: 'zh' },
        'zh-CN': { name: '中文', code: 'zh' },
        'zh-TW': { name: '中文', code: 'zh' },
        'es': { name: 'Español', code: 'es' },
        'fr': { name: 'Français', code: 'fr' },
        'ja': { name: '日本語', code: 'ja' }
    };

    // 提示文本配置
    const suggestionTexts = {
        'en': {
            text: 'We detected your browser language is English. Would you like to switch to the English version?',
            button: 'Switch to English'
        },
        'zh': {
            text: '我们检测到您的浏览器语言是中文，是否切换到中文版本？',
            button: '切换到中文'
        },
        'es': {
            text: 'Detectamos que el idioma de tu navegador es español. ¿Te gustaría cambiar a la versión en español?',
            button: 'Cambiar a español'
        },
        'fr': {
            text: 'Nous avons détecté que la langue de votre navigateur est le français. Souhaitez-vous passer à la version française ?',
            button: 'Passer au français'
        },
        'ja': {
            text: 'ブラウザの言語が日本語に設定されています。日本語版に切り替えますか？',
            button: '日本語に切り替える'
        }
    };

    function detectBrowserLanguage() {
        // 获取浏览器语言
        const browserLang = navigator.language || navigator.userLanguage;
        console.log('Browser language detected:', browserLang);

        // 检查是否支持该语言
        let detectedLang = null;

        // 首先检查完整的语言代码
        if (supportedLanguages[browserLang]) {
            detectedLang = supportedLanguages[browserLang].code;
        } else {
            // 然后检查语言的主要部分（如 'en-US' -> 'en'）
            const mainLang = browserLang.split('-')[0];
            if (supportedLanguages[mainLang]) {
                detectedLang = supportedLanguages[mainLang].code;
            }
        }

        return detectedLang;
    }

    function getCurrentPageLanguage() {
        // 从 URL 路径中获取当前语言
        const path = window.location.pathname;
        const pathParts = path.split('/').filter(part => part.length > 0);

        // 如果路径的第一部分是语言代码，返回它
        if (pathParts.length > 0 && supportedLanguages[pathParts[0]]) {
            return pathParts[0];
        }

        // 否则返回默认语言（中文）
        return 'zh';
    }

    function shouldShowSuggestion(detectedLang, currentLang) {
        // 如果检测到的语言与当前语言不同，则显示建议
        if (!detectedLang || detectedLang === currentLang) {
            return false;
        }
        
        // 如果检测到的语言有对应的提示文本，显示该语言建议
        if (suggestionTexts[detectedLang]) {
            return true;
        }
        
        // 如果检测到的语言没有对应提示文本，但当前是中文页面，建议切换到英文
        if (currentLang === 'zh' && detectedLang !== 'zh') {
            return true;
        }
        
        return false;
    }

    function getLanguageUrl(targetLang) {
        const currentPath = window.location.pathname;
        const currentLang = getCurrentPageLanguage();

        if (targetLang === 'zh') {
            // 中文版本使用根路径（现在中文是默认语言）
            if (currentLang === 'zh') {
                return currentPath;
            } else {
                // 移除语言前缀
                return currentPath.replace(`/${currentLang}`, '') || '/';
            }
        } else {
            // 其他语言版本
            if (currentLang === 'zh') {
                // 从根路径添加语言前缀
                return `/${targetLang}${currentPath === '/' ? '' : currentPath}`;
            } else {
                // 替换现有的语言前缀
                return currentPath.replace(`/${currentLang}`, `/${targetLang}`);
            }
        }
    }

    function showLanguageSuggestion(detectedLang) {
        const suggestionElement = document.getElementById('languageSuggestion');
        const suggestionText = document.getElementById('suggestionText');
        const acceptButton = document.getElementById('acceptLanguage');

        if (!suggestionElement || !suggestionText || !acceptButton) {
            console.log('Language suggestion elements not found');
            return;
        }

        let texts = suggestionTexts[detectedLang];
        let targetLang = detectedLang;
        
        // 如果检测到的语言没有对应的提示文本，且当前是中文页面，建议切换到英文
        if (!texts && getCurrentPageLanguage() === 'zh') {
            texts = suggestionTexts['en'];
            targetLang = 'en';
        }
        
        if (!texts) {
            console.log('No suggestion texts found for language:', detectedLang);
            return;
        }

        // 设置提示文本
        suggestionText.textContent = texts.text;
        acceptButton.textContent = texts.button;

        // 设置按钮点击事件
        acceptButton.onclick = function() {
            const targetUrl = getLanguageUrl(targetLang);
            console.log('Redirecting to:', targetUrl);
            window.location.href = targetUrl;
        };

        // 显示提示
        suggestionElement.classList.remove('hidden');

        // 添加动画效果
        setTimeout(() => {
            suggestionElement.classList.add('show');
        }, 100);

        console.log('Language suggestion shown for:', targetLang);
    }

    function dismissSuggestion() {
        const suggestionElement = document.getElementById('languageSuggestion');
        if (suggestionElement) {
            suggestionElement.classList.remove('show');

            setTimeout(() => {
                suggestionElement.classList.add('hidden');
            }, 300);
        }

        // 记住用户的选择，24小时内不再显示
        localStorage.setItem('languageSuggestionDismissed', Date.now().toString());
    }

    function wasRecentlyDismissed() {
        const dismissedTime = localStorage.getItem('languageSuggestionDismissed');
        if (!dismissedTime) return false;

        const now = Date.now();
        const dismissedTimestamp = parseInt(dismissedTime);
        const hoursSinceDismissed = (now - dismissedTimestamp) / (1000 * 60 * 60);

        // 24小时内不再显示
        return hoursSinceDismissed < 24;
    }

    // 绑定关闭和忽略按钮事件
    const closeSuggestion = document.getElementById('closeSuggestion');
    const dismissSuggestionBtn = document.getElementById('dismissSuggestion');

    if (closeSuggestion) {
        closeSuggestion.addEventListener('click', dismissSuggestion);
    }

    if (dismissSuggestionBtn) {
        dismissSuggestionBtn.addEventListener('click', dismissSuggestion);
    }

    // 主逻辑
    function initLanguageSuggestion() {
        // 检查是否最近被忽略过
        if (wasRecentlyDismissed()) {
            console.log('Language suggestion was recently dismissed, skipping');
            return;
        }

        const detectedLang = detectBrowserLanguage();
        const currentLang = getCurrentPageLanguage();

        console.log('Detected language:', detectedLang);
        console.log('Current page language:', currentLang);

        if (shouldShowSuggestion(detectedLang, currentLang)) {
            // 延迟显示，让页面先加载完成
            setTimeout(() => {
                showLanguageSuggestion(detectedLang);
            }, 1500);
        }
    }

    // 初始化
    initLanguageSuggestion();
});
</script>

<style>
#languageSuggestion {
    transform: translateX(-50%) translateY(-20px);
    opacity: 0;
    transition: all 0.3s ease-out;
}

#languageSuggestion.show {
    transform: translateX(-50%) translateY(0);
    opacity: 1;
}

/* 确保在移动设备上正确显示 */
@media (max-width: 640px) {
    #languageSuggestion {
        max-width: calc(100vw - 2rem);
        left: 50%;
        right: auto;
        top: 80px !important; /* 移动端位置 */
    }
}

/* 桌面端确保不遮挡导航栏 */
@media (min-width: 641px) {
    #languageSuggestion {
        top: 100px !important; /* 桌面端位置 */
    }
}

/* 添加一些视觉效果 */
#languageSuggestion .bg-white {
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}
</style>
