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
                'content' => __('messages.quick_start_welcome')
            ],
            [
                'type' => 'steps',
                'title' => __('messages.quick_start_steps_title'),
                'steps' => [
                    __('messages.quick_start_step_1'),
                    __('messages.quick_start_step_2'),
                    __('messages.quick_start_step_3'),
                    __('messages.quick_start_step_4'),
                    __('messages.quick_start_step_5'),
                    __('messages.quick_start_step_6')
                ]
            ],
            [
                'type' => 'tip',
                'content' => __('messages.quick_start_tip')
            ]
        ];
    }

    private function getBasicUsageContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.basic_usage_intro')
            ],
            [
                'type' => 'section',
                'title' => __('messages.basic_usage_platforms_title'),
                'content' => __('messages.basic_usage_platforms_content')
            ],
            [
                'type' => 'section',
                'title' => __('messages.basic_usage_limits_title'),
                'content' => __('messages.basic_usage_limits_content')
            ]
        ];
    }

    // 入门指南相关内容
    private function getSupportedPlatformsContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.platforms_overview_intro')
            ],
            [
                'type' => 'section',
                'title' => __('messages.platforms_main_title'),
                'content' => __('messages.platforms_main_content')
            ],
            [
                'type' => 'tip',
                'content' => __('messages.platforms_tip')
            ]
        ];
    }

    private function getFirstTimeTipsContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.first_time_tips_intro')
            ],
            [
                'type' => 'steps',
                'title' => __('messages.first_time_tips_title'),
                'steps' => [
                    __('messages.first_time_tip_1'),
                    __('messages.first_time_tip_2'),
                    __('messages.first_time_tip_3'),
                    __('messages.first_time_tip_4'),
                    __('messages.first_time_tip_5')
                ]
            ],
            [
                'type' => 'tip',
                'content' => __('messages.first_time_tips_advice')
            ]
        ];
    }

    // 下载问题相关内容
    private function getDownloadFailedContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.download_failed_intro')
            ],
            [
                'type' => 'section',
                'title' => __('messages.download_failed_reasons_title'),
                'content' => __('messages.download_failed_reasons_content')
            ],
            [
                'type' => 'steps',
                'title' => __('messages.download_failed_solutions_title'),
                'steps' => [
                    __('messages.download_failed_solution_1'),
                    __('messages.download_failed_solution_2'),
                    __('messages.download_failed_solution_3'),
                    __('messages.download_failed_solution_4'),
                    __('messages.download_failed_solution_5')
                ]
            ]
        ];
    }

    private function getSlowSpeedContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.slow_speed_intro')
            ],
            [
                'type' => 'section',
                'title' => __('messages.slow_speed_factors_title'),
                'content' => __('messages.slow_speed_factors_content')
            ],
            [
                'type' => 'steps',
                'title' => __('messages.slow_speed_optimization_title'),
                'steps' => [
                    __('messages.slow_speed_optimization_1'),
                    __('messages.slow_speed_optimization_2'),
                    __('messages.slow_speed_optimization_3'),
                    __('messages.slow_speed_optimization_4'),
                    __('messages.slow_speed_optimization_5')
                ]
            ]
        ];
    }

    private function getQualityIssuesContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.quality_issues_intro')
            ],
            [
                'type' => 'section',
                'title' => __('messages.quality_options_title'),
                'content' => __('messages.quality_options_content')
            ],
            [
                'type' => 'tip',
                'content' => __('messages.quality_limitation_tip')
            ]
        ];
    }

    private function getBrowserCompatibilityContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.browser_compatibility_intro')
            ],
            [
                'type' => 'section',
                'title' => __('messages.browser_recommended_title'),
                'content' => __('messages.browser_recommended_content')
            ],
            [
                'type' => 'section',
                'title' => __('messages.browser_extensions_title'),
                'content' => __('messages.browser_extensions_content')
            ],
            [
                'type' => 'section',
                'title' => __('messages.browser_common_issues_title'),
                'content' => __('messages.browser_common_issues_content')
            ],
            [
                'type' => 'tip',
                'content' => __('messages.browser_security_tip')
            ]
        ];
    }

    // 平台相关内容

    private function getTikTokHelpContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.tiktok_help_intro')
            ],
            [
                'type' => 'section',
                'title' => __('messages.tiktok_features_title'),
                'content' => __('messages.tiktok_features_content')
            ],
            [
                'type' => 'tip',
                'content' => __('messages.tiktok_tip')
            ]
        ];
    }

    private function getInstagramHelpContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.instagram_help_intro')
            ],
            [
                'type' => 'section',
                'title' => __('messages.instagram_content_types_title'),
                'content' => __('messages.instagram_content_types_content')
            ],
            [
                'type' => 'tip',
                'content' => __('messages.instagram_tip')
            ]
        ];
    }

    private function getFacebookHelpContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.facebook_help_intro')
            ],
            [
                'type' => 'section',
                'title' => __('messages.facebook_notes_title'),
                'content' => __('messages.facebook_notes_content')
            ]
        ];
    }

    private function getBilibiliHelpContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.bilibili_help_intro')
            ],
            [
                'type' => 'section',
                'title' => __('messages.bilibili_features_title'),
                'content' => __('messages.bilibili_features_content')
            ],
            [
                'type' => 'tip',
                'content' => __('messages.bilibili_tip')
            ]
        ];
    }

    private function getDouyinHelpContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.douyin_help_intro')
            ],
            [
                'type' => 'section',
                'title' => __('messages.douyin_features_title'),
                'content' => __('messages.douyin_features_content')
            ]
        ];
    }

    // 账户相关内容
    private function getLoginRegistrationContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.login_registration_intro')
            ],
            [
                'type' => 'steps',
                'title' => __('messages.login_registration_steps_title'),
                'steps' => [
                    __('messages.login_registration_step_1'),
                    __('messages.login_registration_step_2'),
                    __('messages.login_registration_step_3'),
                    __('messages.login_registration_step_4'),
                    __('messages.login_registration_step_5')
                ]
            ],
            [
                'type' => 'section',
                'title' => __('messages.login_registration_benefits_title'),
                'content' => __('messages.login_registration_benefits_content')
            ]
        ];
    }

    private function getPasswordResetContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.password_reset_intro')
            ],
            [
                'type' => 'steps',
                'title' => __('messages.password_reset_steps_title'),
                'steps' => [
                    __('messages.password_reset_step_1'),
                    __('messages.password_reset_step_2'),
                    __('messages.password_reset_step_3'),
                    __('messages.password_reset_step_4'),
                    __('messages.password_reset_step_5'),
                    __('messages.password_reset_step_6')
                ]
            ]
        ];
    }

    private function getEmailVerificationContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.email_verification_intro')
            ],
            [
                'type' => 'section',
                'title' => __('messages.email_verification_importance_title'),
                'content' => __('messages.email_verification_importance_content')
            ],
            [
                'type' => 'tip',
                'content' => __('messages.email_verification_tip')
            ]
        ];
    }

    private function getUsageLimitsContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.usage_limits_intro')
            ],
            [
                'type' => 'section',
                'title' => __('messages.usage_limits_explanation_title'),
                'content' => __('messages.usage_limits_explanation_content')
            ],
            [
                'type' => 'tip',
                'content' => __('messages.usage_limits_tip')
            ]
        ];
    }

    private function getReferralSystemContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.referral_system_intro')
            ],
            [
                'type' => 'steps',
                'title' => __('messages.referral_system_steps_title'),
                'steps' => [
                    __('messages.referral_system_step_1'),
                    __('messages.referral_system_step_2'),
                    __('messages.referral_system_step_3'),
                    __('messages.referral_system_step_4'),
                    __('messages.referral_system_step_5')
                ]
            ],
            [
                'type' => 'section',
                'title' => __('messages.referral_system_rules_title'),
                'content' => __('messages.referral_system_rules_content')
            ]
        ];
    }

    // 故障排除相关内容
    private function getCommonErrorsContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.common_errors_intro')
            ],
            [
                'type' => 'section',
                'title' => __('messages.common_errors_types_title'),
                'content' => __('messages.common_errors_types_content')
            ],
            [
                'type' => 'section',
                'title' => __('messages.common_errors_cors_title'),
                'content' => __('messages.common_errors_cors_content')
            ],
            [
                'type' => 'tip',
                'content' => __('messages.common_errors_tip')
            ]
        ];
    }

    private function getNetworkIssuesContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.network_issues_intro')
            ],
            [
                'type' => 'section',
                'title' => __('messages.network_issues_diagnosis_title'),
                'content' => __('messages.network_issues_diagnosis_content')
            ],
            [
                'type' => 'steps',
                'title' => __('messages.network_issues_solutions_title'),
                'steps' => [
                    __('messages.network_issues_solution_1'),
                    __('messages.network_issues_solution_2'),
                    __('messages.network_issues_solution_3'),
                    __('messages.network_issues_solution_4'),
                    __('messages.network_issues_solution_5')
                ]
            ]
        ];
    }

    private function getBrowserIssuesContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.browser_issues_intro')
            ],
            [
                'type' => 'section',
                'title' => __('messages.browser_issues_common_title'),
                'content' => __('messages.browser_issues_common_content')
            ],
            [
                'type' => 'steps',
                'title' => __('messages.browser_issues_solutions_title'),
                'steps' => [
                    __('messages.browser_issues_solution_1'),
                    __('messages.browser_issues_solution_2'),
                    __('messages.browser_issues_solution_3'),
                    __('messages.browser_issues_solution_4'),
                    __('messages.browser_issues_solution_5')
                ]
            ]
        ];
    }

    private function getMobileIssuesContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.mobile_issues_intro')
            ],
            [
                'type' => 'section',
                'title' => __('messages.mobile_issues_common_title'),
                'content' => __('messages.mobile_issues_common_content')
            ],
            [
                'type' => 'tip',
                'content' => __('messages.mobile_issues_tip')
            ]
        ];
    }

    // API相关内容
    private function getApiGettingStartedContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.api_getting_started_intro')
            ],
            [
                'type' => 'steps',
                'title' => __('messages.api_getting_started_steps_title'),
                'steps' => [
                    __('messages.api_getting_started_step_1'),
                    __('messages.api_getting_started_step_2'),
                    __('messages.api_getting_started_step_3'),
                    __('messages.api_getting_started_step_4'),
                    __('messages.api_getting_started_step_5')
                ]
            ],
            [
                'type' => 'section',
                'title' => __('messages.api_getting_started_advantages_title'),
                'content' => __('messages.api_getting_started_advantages_content')
            ]
        ];
    }

    private function getApiAuthenticationContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.api_authentication_intro')
            ],
            [
                'type' => 'section',
                'title' => __('messages.api_authentication_method_title'),
                'content' => __('messages.api_authentication_method_content')
            ],
            [
                'type' => 'tip',
                'content' => __('messages.api_authentication_tip')
            ]
        ];
    }

    private function getApiEndpointsContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.api_endpoints_intro')
            ],
            [
                'type' => 'section',
                'title' => __('messages.api_endpoints_list_title'),
                'content' => __('messages.api_endpoints_list_content')
            ],
            [
                'type' => 'section',
                'title' => __('messages.api_endpoints_usage_title'),
                'content' => __('messages.api_endpoints_usage_content')
            ]
        ];
    }

    private function getApiExamplesContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.api_examples_intro')
            ],
            [
                'type' => 'section',
                'title' => __('messages.api_examples_basic_title'),
                'content' => __('messages.api_examples_basic_content')
            ],
            [
                'type' => 'section',
                'title' => __('messages.api_examples_advanced_title'),
                'content' => __('messages.api_examples_advanced_content')
            ]
        ];
    }

    private function getApiRateLimitsContent()
    {
        return [
            [
                'type' => 'text',
                'content' => __('messages.api_rate_limits_intro')
            ],
            [
                'type' => 'section',
                'title' => __('messages.api_rate_limits_tiers_title'),
                'content' => __('messages.api_rate_limits_tiers_content')
            ],
            [
                'type' => 'section',
                'title' => __('messages.api_rate_limits_management_title'),
                'content' => __('messages.api_rate_limits_management_content')
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
