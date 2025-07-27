<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HelpController extends Controller
{
    /**
     * 帮助中心首页
     */
    public function index()
    {
        $categories = $this->getHelpCategories();
        $popularQuestions = $this->getPopularQuestions();

        return view('pages.help.layout', compact('categories', 'popularQuestions'));
    }



    /**
     * 帮助分类页面
     */
    public function category($category)
    {
        $categories = $this->getHelpCategories();
        $popularQuestions = $this->getPopularQuestions();
        $categoryData = $this->getCategoryData($category);

        if (!$categoryData) {
            abort(404);
        }

        return view('pages.help.layout', compact('categories', 'popularQuestions', 'categoryData', 'category'))->with('currentCategory', $category);
    }

    /**
     * 具体帮助文章
     */
    public function article($category, $article)
    {
        $categories = $this->getHelpCategories();
        $popularQuestions = $this->getPopularQuestions();
        $articleData = $this->getArticleData($category, $article);

        if (!$articleData) {
            abort(404);
        }

        return view('pages.help.layout', compact('categories', 'popularQuestions', 'articleData', 'category', 'article'))->with('currentCategory', $category);
        return HelpController::processHelpContent('使用跨域插件<a href="">CORS Control</a>');
    }

    /**
     * 搜索帮助内容
     */
    public function search(Request $request)
    {
        $categories = $this->getHelpCategories();
        $popularQuestions = $this->getPopularQuestions();
        $query = $request->get('q', '');
        $results = $this->searchHelpContent($query);

        return view('pages.help.search', compact('categories', 'popularQuestions', 'results', 'query'));
    }

    /**
     * 获取帮助分类
     */
    private function getHelpCategories()
    {
        return [
            'getting-started' => [
                'title' => __('messages.getting_started'),
                'description' => __('messages.getting_started_description'),
                'icon' => 'academic-cap',
                'color' => 'blue',
                'articles' => [
                    'quick-start' => __('messages.quick_start_guide'),
                    'basic-usage' => __('messages.basic_usage'),
                    'supported-platforms' => __('messages.supported_platforms_overview'),
                    'first-time-tips' => __('messages.first_time_user_tips'),
                ]
            ],
            'download-issues' => [
                'title' => __('messages.download_issues'),
                'description' => __('messages.download_issues_description'),
                'icon' => 'download',
                'color' => 'green',
                'articles' => [
                    'download-failed' => __('messages.download_failed'),
                    'slow-speed' => __('messages.slow_download_speed'),
                    'quality-issues' => __('messages.video_quality_issues'),
                    'browser-compatibility' => __('messages.browser_compatibility'),
                ]
            ],
            'platforms' => [
                'title' => __('messages.supported_platforms'),
                'description' => __('messages.supported_platforms_help_description'),
                'icon' => 'globe-alt',
                'color' => 'purple',
                'articles' => [
                    'youtube' => __('messages.youtube_help'),
                    'tiktok' => __('messages.tiktok_help'),
                    'instagram' => __('messages.instagram_help'),
                    'facebook' => __('messages.facebook_help'),
                    'bilibili' => __('messages.bilibili_help'),
                    'douyin' => __('messages.douyin_help'),
                ]
            ],
            'account' => [
                'title' => __('messages.account_settings'),
                'description' => __('messages.account_settings_description'),
                'icon' => 'user-circle',
                'color' => 'orange',
                'articles' => [
                    'login-registration' => __('messages.login_registration'),
                    'password-reset' => __('messages.password_reset'),
                    'email-verification' => __('messages.email_verification'),
                    'usage-limits' => __('messages.usage_limits'),
                    'referral-system' => __('messages.referral_system'),
                ]
            ],
            'troubleshooting' => [
                'title' => __('messages.troubleshooting'),
                'description' => __('messages.troubleshooting_description'),
                'icon' => 'exclamation-triangle',
                'color' => 'red',
                'articles' => [
                    'common-errors' => __('messages.common_errors'),
                    'network-issues' => __('messages.network_issues'),
                    'browser-issues' => __('messages.browser_issues'),
                    'mobile-issues' => __('messages.mobile_issues'),
                ]
            ],
            'api' => [
                'title' => __('messages.api_documentation'),
                'description' => __('messages.api_documentation_description'),
                'icon' => 'code',
                'color' => 'indigo',
                'articles' => [
                    'getting-started' => __('messages.api_getting_started'),
                    'authentication' => __('messages.api_authentication'),
                    'endpoints' => __('messages.api_endpoints'),
                    'examples' => __('messages.api_examples'),
                    'rate-limits' => __('messages.api_rate_limits'),
                ]
            ]
        ];
    }

    /**
     * 获取热门问题
     */
    private function getPopularQuestions()
    {
        return [
            [
                'question' => __('messages.how_to_download_video'),
                'answer' => __('messages.how_to_download_video_detailed'),
                'category' => 'getting-started',
                'article' => 'basic-usage'
            ],
            [
                'question' => __('messages.supported_video_formats'),
                'answer' => __('messages.supported_video_formats_detailed'),
                'category' => 'getting-started',
                'article' => 'supported-platforms'
            ],
            [
                'question' => __('messages.is_service_free'),
                'answer' => __('messages.is_service_free_detailed'),
                'category' => 'account',
                'article' => 'usage-limits'
            ],
            [
                'question' => __('messages.download_not_working'),
                'answer' => __('messages.download_not_working_detailed'),
                'category' => 'troubleshooting',
                'article' => 'common-errors'
            ],
            [
                'question' => __('messages.video_quality_options'),
                'answer' => __('messages.video_quality_options_answer'),
                'category' => 'download-issues',
                'article' => 'quality-issues'
            ],
            [
                'question' => __('messages.mobile_usage'),
                'answer' => __('messages.mobile_usage_answer'),
                'category' => 'troubleshooting',
                'article' => 'mobile-issues'
            ]
        ];
    }

    /**
     * 获取分类数据
     */
    private function getCategoryData($category)
    {
        $categories = $this->getHelpCategories();
        return $categories[$category] ?? null;
    }

    /**
     * 获取文章数据
     */
    private function getArticleData($category, $article)
    {
        // 这里可以从数据库或文件系统获取文章内容
        // 现在先返回模拟数据
        $articles = $this->getArticleContent();

        return $articles[$category][$article] ?? null;
    }

    /**
     * 搜索帮助内容
     */
    private function searchHelpContent($query)
    {
        if (empty($query)) {
            return [];
        }

        $results = [];
        $categories = $this->getHelpCategories();
        $popularQuestions = $this->getPopularQuestions();

        // 搜索分类和文章标题
        foreach ($categories as $categoryKey => $categoryData) {
            if (stripos($categoryData['title'], $query) !== false ||
                stripos($categoryData['description'], $query) !== false) {
                $results[] = [
                    'type' => 'category',
                    'title' => $categoryData['title'],
                    'description' => $categoryData['description'],
                    'url' => route('help.category', $categoryKey)
                ];
            }

            foreach ($categoryData['articles'] as $articleKey => $articleTitle) {
                if (stripos($articleTitle, $query) !== false) {
                    $results[] = [
                        'type' => 'article',
                        'title' => $articleTitle,
                        'category' => $categoryData['title'],
                        'url' => route('help.article', [$categoryKey, $articleKey])
                    ];
                }
            }
        }

        // 搜索热门问题
        foreach ($popularQuestions as $qa) {
            if (stripos($qa['question'], $query) !== false ||
                stripos($qa['answer'], $query) !== false) {
                $results[] = [
                    'type' => 'faq',
                    'title' => $qa['question'],
                    'description' => substr($qa['answer'], 0, 150) . '...',
                    'url' => route('help.article', [$qa['category'], $qa['article']])
                ];
            }
        }

        return $results;
    }

    /**
     * 获取文章内容
     */
    private function getArticleContent()
    {
        return [
            'getting-started' => [
                'quick-start' => [
                    'title' => __('messages.quick_start_guide'),
                    'content' => $this->getQuickStartContent(),
                    'last_updated' => '2024-01-15'
                ],
                'basic-usage' => [
                    'title' => __('messages.basic_usage'),
                    'content' => $this->getBasicUsageContent(),
                    'last_updated' => '2024-01-15'
                ],
                'supported-platforms' => [
                    'title' => __('messages.supported_platforms_overview'),
                    'content' => $this->getSupportedPlatformsContent(),
                    'last_updated' => '2024-01-15'
                ],
                'first-time-tips' => [
                    'title' => __('messages.first_time_user_tips'),
                    'content' => $this->getFirstTimeTipsContent(),
                    'last_updated' => '2024-01-15'
                ]
            ],
            'download-issues' => [
                'download-failed' => [
                    'title' => __('messages.download_failed'),
                    'content' => $this->getDownloadFailedContent(),
                    'last_updated' => '2024-01-15'
                ],
                'slow-speed' => [
                    'title' => __('messages.slow_download_speed'),
                    'content' => $this->getSlowSpeedContent(),
                    'last_updated' => '2024-01-15'
                ],
                'quality-issues' => [
                    'title' => __('messages.video_quality_issues'),
                    'content' => $this->getQualityIssuesContent(),
                    'last_updated' => '2024-01-15'
                ],
                'browser-compatibility' => [
                    'title' => __('messages.browser_compatibility'),
                    'content' => $this->getBrowserCompatibilityContent(),
                    'last_updated' => '2024-01-15'
                ]
            ],
            'platforms' => [
                'youtube' => [
                    'title' => __('messages.youtube_help'),
                    'content' => $this->getYouTubeHelpContent(),
                    'last_updated' => '2024-01-15'
                ],
                'tiktok' => [
                    'title' => __('messages.tiktok_help'),
                    'content' => $this->getTikTokHelpContent(),
                    'last_updated' => '2024-01-15'
                ],
                'instagram' => [
                    'title' => __('messages.instagram_help'),
                    'content' => $this->getInstagramHelpContent(),
                    'last_updated' => '2024-01-15'
                ],
                'facebook' => [
                    'title' => __('messages.facebook_help'),
                    'content' => $this->getFacebookHelpContent(),
                    'last_updated' => '2024-01-15'
                ],
                'bilibili' => [
                    'title' => __('messages.bilibili_help'),
                    'content' => $this->getBilibiliHelpContent(),
                    'last_updated' => '2024-01-15'
                ],
                'douyin' => [
                    'title' => __('messages.douyin_help'),
                    'content' => $this->getDouyinHelpContent(),
                    'last_updated' => '2024-01-15'
                ]
            ],
            'account' => [
                'login-registration' => [
                    'title' => __('messages.login_registration'),
                    'content' => $this->getLoginRegistrationContent(),
                    'last_updated' => '2024-01-15'
                ],
                'password-reset' => [
                    'title' => __('messages.password_reset'),
                    'content' => $this->getPasswordResetContent(),
                    'last_updated' => '2024-01-15'
                ],
                'email-verification' => [
                    'title' => __('messages.email_verification'),
                    'content' => $this->getEmailVerificationContent(),
                    'last_updated' => '2024-01-15'
                ],
                'usage-limits' => [
                    'title' => __('messages.usage_limits'),
                    'content' => $this->getUsageLimitsContent(),
                    'last_updated' => '2024-01-15'
                ],
                'referral-system' => [
                    'title' => __('messages.referral_system'),
                    'content' => $this->getReferralSystemContent(),
                    'last_updated' => '2024-01-15'
                ]
            ],
            'troubleshooting' => [
                'common-errors' => [
                    'title' => __('messages.common_errors'),
                    'content' => $this->getCommonErrorsContent(),
                    'last_updated' => '2024-01-15'
                ],
                'network-issues' => [
                    'title' => __('messages.network_issues'),
                    'content' => $this->getNetworkIssuesContent(),
                    'last_updated' => '2024-01-15'
                ],
                'browser-issues' => [
                    'title' => __('messages.browser_issues'),
                    'content' => $this->getBrowserIssuesContent(),
                    'last_updated' => '2024-01-15'
                ],
                'mobile-issues' => [
                    'title' => __('messages.mobile_issues'),
                    'content' => $this->getMobileIssuesContent(),
                    'last_updated' => '2024-01-15'
                ]
            ],
            'api' => [
                'getting-started' => [
                    'title' => __('messages.api_getting_started'),
                    'content' => $this->getApiGettingStartedContent(),
                    'last_updated' => '2024-01-15'
                ],
                'authentication' => [
                    'title' => __('messages.api_authentication'),
                    'content' => $this->getApiAuthenticationContent(),
                    'last_updated' => '2024-01-15'
                ],
                'endpoints' => [
                    'title' => __('messages.api_endpoints'),
                    'content' => $this->getApiEndpointsContent(),
                    'last_updated' => '2024-01-15'
                ],
                'examples' => [
                    'title' => __('messages.api_examples'),
                    'content' => $this->getApiExamplesContent(),
                    'last_updated' => '2024-01-15'
                ],
                'rate-limits' => [
                    'title' => __('messages.api_rate_limits'),
                    'content' => $this->getApiRateLimitsContent(),
                    'last_updated' => '2024-01-15'
                ]
            ]
        ];
    }

    private function getQuickStartContent()
    {
        return [
            [
                'type' => 'text',
                'content' => '欢迎使用 VideoParser.top！这是一个功能强大的在线视频解析下载工具，支持多个主流视频平台。'
            ],
            [
                'type' => 'steps',
                'title' => '快速开始步骤：',
                'steps' => [
                    '访问 VideoParser.top 首页',
                    '复制您想要下载的视频链接',
                    '将链接粘贴到输入框中',
                    '点击"解析"按钮',
                    '选择合适的画质和格式',
                    '点击"下载"按钮开始下载'
                ]
            ],
            [
                'type' => 'tip',
                'content' => '提示：注册账户可以获得更多的每日解析次数！'
            ]
        ];
    }

    private function getBasicUsageContent()
    {
        return [
            [
                'type' => 'text',
                'content' => 'VideoParser.top 的基本使用非常简单，只需要几个步骤就能完成视频下载。'
            ],
            [
                'type' => 'section',
                'title' => '支持的平台',
                'content' => '我们支持以下主流视频平台：YouTube、TikTok、Instagram、Facebook、Twitter、B站、抖音等。'
            ],
            [
                'type' => 'section',
                'title' => '使用限制',
                'content' => '游客用户每日有一定的解析次数限制，注册用户可获得更多次数。具体限制请查看账户设置页面。'
            ]
        ];
    }

    // 入门指南相关内容
    private function getSupportedPlatformsContent()
    {
        return [
            [
                'type' => 'text',
                'content' => 'VideoParser.top 支持多个主流视频平台，为您提供全面的视频解析服务。'
            ],
            [
                'type' => 'section',
                'title' => '主要支持平台',
                'content' => '• YouTube - 全球最大的视频分享平台\n• TikTok - 短视频社交平台\n• Instagram - 图片和视频分享平台\n• Facebook - 社交网络平台\n• Twitter - 微博社交平台\n• B站 - 中国领先的视频弹幕网站\n• 抖音 - 中国短视频平台'
            ],
            [
                'type' => 'tip',
                'content' => '我们会持续添加对新平台的支持，如果您需要特定平台的支持，请联系我们。'
            ]
        ];
    }

    private function getFirstTimeTipsContent()
    {
        return [
            [
                'type' => 'text',
                'content' => '作为新用户，这些技巧将帮助您更好地使用 VideoParser.top。'
            ],
            [
                'type' => 'steps',
                'title' => '新手使用技巧：',
                'steps' => [
                    '注册账户获得更多解析次数',
                    '收藏常用的视频链接',
                    '选择合适的视频质量以节省流量',
                    '使用批量下载功能提高效率',
                    '关注我们的更新获取新功能'
                ]
            ],
            [
                'type' => 'tip',
                'content' => '建议先从简单的单个视频下载开始，熟悉流程后再尝试批量下载等高级功能。'
            ]
        ];
    }

    // 下载问题相关内容
    private function getDownloadFailedContent()
    {
        return [
            [
                'type' => 'text',
                'content' => '下载失败是用户遇到的常见问题之一，以下是一些常见原因和解决方法。'
            ],
            [
                'type' => 'section',
                'title' => '常见原因',
                'content' => '• 网络连接不稳定\n• 视频链接已失效\n• 平台限制或地区限制\n• 浏览器兼容性问题\n• 视频不允许跨域请求'
            ],
            [
                'type' => 'steps',
                'title' => '解决步骤：',
                'steps' => [
                    '检查网络连接是否正常',
                    '确认视频链接是否有效',
                    '尝试刷新页面重新解析',
                    '使用跨域插件<a href="" class="text-blue-600">CORS Control</a>',
                    '尝试其他平台'
                ]
            ]
        ];
    }

    private function getSlowSpeedContent()
    {
        return [
            [
                'type' => 'text',
                'content' => '下载速度慢可能由多种因素造成，以下是一些优化建议。'
            ],
            [
                'type' => 'section',
                'title' => '影响因素',
                'content' => '• 网络带宽限制\n• 服务器负载\n• 视频文件大小\n• 地理位置距离\n• 同时下载数量'
            ],
            [
                'type' => 'steps',
                'title' => '优化方法：',
                'steps' => [
                    '选择较低的视频质量',
                    '避免同时下载多个视频',
                    '在网络较好的时段下载',
                    '关闭其他占用带宽的应用',
                    '考虑升级网络套餐'
                ]
            ]
        ];
    }

    private function getQualityIssuesContent()
    {
        return [
            [
                'type' => 'text',
                'content' => '视频质量问题通常与原始视频质量和平台限制有关。'
            ],
            [
                'type' => 'section',
                'title' => '质量选项说明',
                'content' => '• 原画质：保持原始视频质量\n• 高清：1080p 高清画质\n• 标清：720p 标准画质\n• 流畅：480p 或更低画质'
            ],
            [
                'type' => 'tip',
                'content' => '下载质量不会超过原始视频的质量。如果原视频是720p，则无法下载1080p版本。'
            ]
        ];
    }

    private function getBrowserCompatibilityContent()
    {
        return [
            [
                'type' => 'text',
                'content' => '为了获得最佳体验，建议使用现代浏览器访问我们的服务。\n\n某些浏览器可能需要安装扩展程序来解决跨域问题。'
            ],
            [
                'type' => 'section',
                'title' => '推荐浏览器',
                'content' => '• Chrome 80+ (推荐)\n• Firefox 75+\n• Safari 13+\n• Edge 80+\n• Opera 67+'
            ],
            [
                'type' => 'section',
                'title' => '推荐扩展程序',
                'content' => '如果遇到跨域问题，建议安装以下扩展程序：\n\n• <a href="https://chrome.google.com/webstore/detail/cors-unblock/lfhmikememgdcahcdlaciloancbhjino">CORS Unblock</a> - Chrome扩展，解决跨域访问问题\n• <a href="https://addons.mozilla.org/en-US/firefox/addon/cors-everywhere/">CORS Everywhere</a> - Firefox扩展\n• <a href="https://chrome.google.com/webstore/detail/allow-cors/lhobafahddgcelffkeicbaginigeejlf">Allow CORS</a> - 另一个Chrome CORS解决方案'
            ],
            [
                'type' => 'section',
                'title' => '常见问题',
                'content' => '如果遇到兼容性问题，请尝试：\n• 更新浏览器到最新版本\n• 清除浏览器缓存和Cookie\n• 禁用广告拦截器\n• 启用JavaScript\n• 安装上述推荐的CORS扩展程序'
            ],
            [
                'type' => 'tip',
                'content' => '注意：安装扩展程序时请确保从官方商店下载，避免安装恶意软件。使用完毕后可以禁用扩展程序以保证安全。'
            ]
        ];
    }

    // 平台相关内容
    private function getYouTubeHelpContent()
    {
        return [
            [
                'type' => 'text',
                'content' => 'YouTube 是我们支持的主要平台之一，提供多种质量选项。'
            ],
            [
                'type' => 'steps',
                'title' => 'YouTube 视频下载步骤：',
                'steps' => [
                    '在 YouTube 上找到要下载的视频',
                    '复制视频页面的 URL',
                    '粘贴到我们的解析框中',
                    '选择合适的质量和格式',
                    '点击下载按钮'
                ]
            ],
            [
                'type' => 'tip',
                'content' => 'YouTube 支持多种质量选项，包括4K、1080p、720p等。请根据需要选择合适的质量。'
            ]
        ];
    }

    private function getTikTokHelpContent()
    {
        return [
            [
                'type' => 'text',
                'content' => 'TikTok 短视频下载支持去水印功能，让您获得更清洁的视频。'
            ],
            [
                'type' => 'section',
                'title' => '特殊功能',
                'content' => '• 自动去除 TikTok 水印\n• 支持音频单独下载\n• 保持原始质量\n• 快速解析处理'
            ],
            [
                'type' => 'tip',
                'content' => 'TikTok 视频通常为竖屏格式，下载后可在移动设备上获得最佳观看体验。'
            ]
        ];
    }

    private function getInstagramHelpContent()
    {
        return [
            [
                'type' => 'text',
                'content' => 'Instagram 支持图片、视频和故事的下载。'
            ],
            [
                'type' => 'section',
                'title' => '支持内容类型',
                'content' => '• 普通帖子视频\n• Instagram Stories\n• IGTV 视频\n• Reels 短视频'
            ],
            [
                'type' => 'tip',
                'content' => '请确保您有权下载相关内容，并遵守 Instagram 的使用条款。'
            ]
        ];
    }

    private function getFacebookHelpContent()
    {
        return [
            [
                'type' => 'text',
                'content' => 'Facebook 视频下载支持公开视频和个人分享视频。'
            ],
            [
                'type' => 'section',
                'title' => '注意事项',
                'content' => '• 仅支持公开视频\n• 需要有效的视频链接\n• 某些视频可能有地区限制\n• 尊重原作者版权'
            ]
        ];
    }

    private function getBilibiliHelpContent()
    {
        return [
            [
                'type' => 'text',
                'content' => 'B站（Bilibili）是中国领先的视频弹幕网站，我们提供完整的下载支持。'
            ],
            [
                'type' => 'section',
                'title' => '支持功能',
                'content' => '• 多P视频下载\n• 弹幕文件下载\n• 多种清晰度选择\n• 音频单独提取'
            ],
            [
                'type' => 'tip',
                'content' => 'B站视频下载请遵守相关法律法规，仅用于个人学习和研究目的。'
            ]
        ];
    }

    private function getDouyinHelpContent()
    {
        return [
            [
                'type' => 'text',
                'content' => '抖音视频下载支持去水印和高质量下载。'
            ],
            [
                'type' => 'section',
                'title' => '特色功能',
                'content' => '• 自动去除抖音水印\n• 保持原始音质\n• 支持批量下载\n• 快速解析处理'
            ]
        ];
    }

    // 账户相关内容
    private function getLoginRegistrationContent()
    {
        return [
            [
                'type' => 'text',
                'content' => '注册账户可以获得更多功能和更高的使用限制。'
            ],
            [
                'type' => 'steps',
                'title' => '注册步骤：',
                'steps' => [
                    '点击页面右上角的"注册"按钮',
                    '填写邮箱地址和密码',
                    '点击"注册"完成账户创建',
                    '查收邮箱验证邮件',
                    '点击验证链接激活账户'
                ]
            ],
            [
                'type' => 'section',
                'title' => '注册优势',
                'content' => '• 每日解析次数更多\n• 支持批量下载\n• 下载历史记录\n• 优先客服支持'
            ]
        ];
    }

    private function getPasswordResetContent()
    {
        return [
            [
                'type' => 'text',
                'content' => '如果忘记密码，可以通过邮箱重置密码。'
            ],
            [
                'type' => 'steps',
                'title' => '密码重置步骤：',
                'steps' => [
                    '点击登录页面的"忘记密码"链接',
                    '输入注册时使用的邮箱地址',
                    '点击"发送重置邮件"',
                    '查收邮箱中的重置邮件',
                    '点击邮件中的重置链接',
                    '设置新密码并确认'
                ]
            ]
        ];
    }

    private function getEmailVerificationContent()
    {
        return [
            [
                'type' => 'text',
                'content' => '邮箱验证是账户安全的重要步骤，确保您能正常使用所有功能。'
            ],
            [
                'type' => 'section',
                'title' => '验证重要性',
                'content' => '• 确保账户安全\n• 接收重要通知\n• 密码重置功能\n• 完整功能访问'
            ],
            [
                'type' => 'tip',
                'content' => '如果没有收到验证邮件，请检查垃圾邮件文件夹，或点击重新发送验证邮件。'
            ]
        ];
    }

    private function getUsageLimitsContent()
    {
        return [
            [
                'type' => 'text',
                'content' => '为了保证服务质量，我们对不同用户类型设置了相应的使用限制。'
            ],
            [
                'type' => 'section',
                'title' => '限制说明',
                'content' => '• 游客用户：每日6次解析\n• 注册用户：每日10次解析\n• 推荐奖励：每成功推荐1人获得20次额外解析\n• API用户：根据套餐不同有相应限制'
            ],
            [
                'type' => 'tip',
                'content' => '限制每日凌晨重置。如需更高限制，请考虑使用我们的API服务。'
            ]
        ];
    }

    private function getReferralSystemContent()
    {
        return [
            [
                'type' => 'text',
                'content' => '推荐系统让您通过分享获得额外的解析次数奖励。'
            ],
            [
                'type' => 'steps',
                'title' => '如何使用推荐系统：',
                'steps' => [
                    '登录您的账户',
                    '进入用户中心',
                    '找到推荐链接',
                    '分享给朋友或社交媒体',
                    '朋友注册后您获得奖励'
                ]
            ],
            [
                'type' => 'section',
                'title' => '奖励规则',
                'content' => '• 每成功推荐1人获得20次解析奖励\n• 被推荐人需要完成邮箱验证\n• 奖励次数永久有效\n• 无推荐人数限制'
            ]
        ];
    }

    // 故障排除相关内容
    private function getCommonErrorsContent()
    {
        return [
            [
                'type' => 'text',
                'content' => '以下是用户经常遇到的错误及其解决方法。\n\n如果您遇到CORS相关错误，建议安装浏览器扩展程序来解决。'
            ],
            [
                'type' => 'section',
                'title' => '常见错误类型',
                'content' => '• "解析失败" - 视频链接无效或平台限制\n• "网络超时" - 网络连接问题\n• "格式不支持" - 视频格式限制\n• "下载中断" - 网络不稳定\n• "权限不足" - 账户限制\n• "CORS错误" - 跨域访问被阻止'
            ],
            [
                'type' => 'section',
                'title' => 'CORS错误解决方案',
                'content' => '如果遇到跨域访问错误，请安装以下扩展程序：\n\n**Chrome浏览器：**\n• <a href="https://chrome.google.com/webstore/detail/cors-unblock/lfhmikememgdcahcdlaciloancbhjino">CORS Unblock</a>\n• <a href="https://chrome.google.com/webstore/detail/allow-cors/lhobafahddgcelffkeicbaginigeejlf">Allow CORS</a>\n\n**Firefox浏览器：**\n• <a href="https://addons.mozilla.org/en-US/firefox/addon/cors-everywhere/">CORS Everywhere</a>'
            ],
            [
                'type' => 'tip',
                'content' => '如果遇到未列出的错误，请联系客服并提供详细的错误信息。\n\n安装扩展程序后，记得在使用完毕后禁用以确保浏览器安全。'
            ]
        ];
    }

    private function getNetworkIssuesContent()
    {
        return [
            [
                'type' => 'text',
                'content' => '网络问题是影响使用体验的主要因素之一。'
            ],
            [
                'type' => 'section',
                'title' => '网络诊断',
                'content' => '• 检查网络连接状态\n• 测试网络速度\n• 确认DNS设置\n• 检查防火墙设置\n• 尝试更换网络环境'
            ],
            [
                'type' => 'steps',
                'title' => '解决步骤：',
                'steps' => [
                    '重启路由器和设备',
                    '尝试使用移动网络',
                    '清除DNS缓存',
                    '联系网络服务提供商',
                    '使用VPN（如果适用）'
                ]
            ]
        ];
    }

    private function getBrowserIssuesContent()
    {
        return [
            [
                'type' => 'text',
                'content' => '浏览器相关问题通常可以通过简单的设置调整来解决。'
            ],
            [
                'type' => 'section',
                'title' => '常见浏览器问题',
                'content' => '• JavaScript被禁用\n• Cookie被阻止\n• 缓存过期\n• 扩展程序冲突\n• 版本过旧'
            ],
            [
                'type' => 'steps',
                'title' => '解决方法：',
                'steps' => [
                    '启用JavaScript和Cookie',
                    '清除浏览器缓存',
                    '禁用广告拦截器',
                    '更新浏览器版本',
                    '尝试隐私模式'
                ]
            ]
        ];
    }

    private function getMobileIssuesContent()
    {
        return [
            [
                'type' => 'text',
                'content' => '移动设备使用时可能遇到的特殊问题和解决方案。'
            ],
            [
                'type' => 'section',
                'title' => '移动端常见问题',
                'content' => '• 触摸操作不响应\n• 页面显示异常\n• 下载功能受限\n• 网络切换问题\n• 存储空间不足'
            ],
            [
                'type' => 'tip',
                'content' => '建议在WiFi环境下使用，以获得更好的体验和避免流量消耗。'
            ]
        ];
    }

    // API相关内容
    private function getApiGettingStartedContent()
    {
        return [
            [
                'type' => 'text',
                'content' => 'VideoParser.top API 为开发者提供强大的视频解析功能。'
            ],
            [
                'type' => 'steps',
                'title' => 'API 快速开始：',
                'steps' => [
                    '注册开发者账户',
                    '获取API密钥',
                    '阅读API文档',
                    '进行测试调用',
                    '集成到您的应用'
                ]
            ],
            [
                'type' => 'section',
                'title' => 'API 优势',
                'content' => '• 高速解析\n• 稳定可靠\n• 多格式支持\n• 详细文档\n• 技术支持'
            ]
        ];
    }

    private function getApiAuthenticationContent()
    {
        return [
            [
                'type' => 'text',
                'content' => 'API 认证确保您的请求安全和合法。'
            ],
            [
                'type' => 'section',
                'title' => '认证方式',
                'content' => '我们使用API密钥进行认证。请在请求头中包含：\nAuthorization: Bearer YOUR_API_KEY'
            ],
            [
                'type' => 'tip',
                'content' => '请妥善保管您的API密钥，不要在客户端代码中暴露。'
            ]
        ];
    }

    private function getApiEndpointsContent()
    {
        return [
            [
                'type' => 'text',
                'content' => 'API 提供多个端点来满足不同的需求。'
            ],
            [
                'type' => 'section',
                'title' => '主要端点',
                'content' => '• POST /api/parse - 解析视频链接\n• GET /api/status - 查询解析状态\n• GET /api/platforms - 获取支持平台\n• GET /api/usage - 查询使用统计'
            ]
        ];
    }

    private function getApiExamplesContent()
    {
        return [
            [
                'type' => 'text',
                'content' => '以下是一些常用的API调用示例。'
            ],
            [
                'type' => 'section',
                'title' => 'cURL 示例',
                'content' => 'curl -X POST https://videoparser.top/api/parse \\\n  -H "Authorization: Bearer YOUR_API_KEY" \\\n  -H "Content-Type: application/json" \\\n  -d \'{"url": "https://youtube.com/watch?v=example"}\''
            ]
        ];
    }

    private function getApiRateLimitsContent()
    {
        return [
            [
                'type' => 'text',
                'content' => 'API 速率限制确保服务的稳定性和公平使用。'
            ],
            [
                'type' => 'section',
                'title' => '限制说明',
                'content' => '• 免费版：0次/月\n• 专业版：10000次/月\n• 企业版：无限制\n• 单次请求间隔：最少1秒'
            ],
            [
                'type' => 'tip',
                'content' => '超出限制时会返回429状态码，请适当控制请求频率。'
            ]
        ];
    }

    /**
     * 安全地处理帮助内容：处理链接和换行符
     */
    public static function processHelpContent($content)
    {
        return str_replace('\n', "<br>", $content);
    }
}
