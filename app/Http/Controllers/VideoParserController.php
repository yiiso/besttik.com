<?php

namespace App\Http\Controllers;

use App\Models\ParseLog;
use App\Service\BlibliService;
use App\Service\DouyinService;
use App\Service\ParseService;
use App\Service\TiktokService;
use App\Service\TwitterService;
use App\Service\YoutubeService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class VideoParserController extends Controller
{
    /**
     * 解析视频链接
     */
    public function parse(Request $request): JsonResponse
    {
        // 验证输入
        $validator = Validator::make($request->all(), [
            'video_url' => 'required|string'
        ], [
            'video_url.required' => __('messages.invalid_url'),
            'video_url.string' => __('messages.invalid_url')
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        $videoUrl = $request->input('video_url');
        $userId = Auth::id();
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $platform = null;
        $videoInfo = null;
        $isSuccess = false;
        $errorMessage = null;

        $videoUrl = $this->parseUrl($videoUrl);

        try {
            // 检查每日解析限制
            if (ParseLog::isExceedDailyLimit($userId, $ipAddress)) {
                $remainingCount = ParseLog::getRemainingCount($userId, $ipAddress);
                $guestLimit = config('app.daily_parse_limit_guest', 3);
                $userLimit = config('app.daily_parse_limit_user', 10);

                if ($userId) {
                    $message = __('messages.daily_limit_exceeded_user', ['limit' => $userLimit]);
                } else {
                    $message = __('messages.daily_limit_exceeded_guest', ['limit' => $guestLimit]);
                }

                // 记录失败的解析尝试
                ParseLog::logParse(
                    $userId,
                    $ipAddress,
                    $videoUrl,
                    null,
                    false,
                    $message,
                    null,
                    $userAgent
                );

                return response()->json([
                    'status' => 'error',
                    'message' => $message,
                    'remaining_count' => $remainingCount,
                    'need_login' => !$userId,
                    'daily_limit' => $userId ? $userLimit : $guestLimit
                ], 429);
            }

            // 检测视频平台
            $platform = $this->detectPlatform($videoUrl);

            switch ($platform){
                case 'tiktok':
                    $videoInfo = (new TiktokService())->parseVideoFromAPI($videoUrl);
                    break;
                case 'bilibili':
                    $videoInfo = (new BlibliService())->parseVideoFromAPI($videoUrl);
                    break;
                case 'youtube':
                    $cookiePath = '/www/wwwroot/videoparser.top/storage/youtube-cookies.txt';
                    $format = 'bv*,ba*';
                    $videoInfo = (new YoutubeService())->getVideoUrl($videoUrl, $format, $cookiePath);

                    break;
                case 'twitter':
                case 'facebook':
                    $format = 'bv*,ba*';
                    $videoInfo = (new TwitterService())->getVideoUrl($videoUrl, $format);
                    break;
                case 'douyin':
                    $videoInfo = (new DouyinService())->parseVideoFromAPI($videoUrl);
                    break;
                default :
                    try {
                        $format = 'bv*,ba*';
                        $videoInfo = (new TwitterService())->getVideoUrl($videoUrl, $format);
                    }catch (\Exception $exception){
                        $videoInfo = (new DouyinService())->parseVideoFromAPI($videoUrl);
                    }


            }
            $isSuccess = true;

            // 如果是登录用户，优先使用奖励次数
            if ($userId) {
                $user = Auth::user();
                $baseLimit = config('app.daily_parse_limit_user', 10);
                $todayUsed = ParseLog::getTodaySuccessCountByUser($userId);

                // 如果超过基础限制，使用奖励次数
                if ($todayUsed >= $baseLimit && $user->bonus_parse_count > 0) {
                    $user->useBonusParseCount(1);
                }
            }

            // 记录成功的解析
            ParseLog::logParse(
                $userId,
                $ipAddress,
                $videoUrl,
                $platform,
                true,
                null,
                $videoInfo,
                $userAgent
            );

            // 获取剩余次数
            $remainingCount = ParseLog::getRemainingCount($userId, $ipAddress);
            $dailyLimit = $userId ? Auth::user()->getTotalDailyLimit() : config('app.daily_parse_limit_guest', 3);

            return response()->json([
                'status' => 'success',
                'data' => $videoInfo,
                'platform' => $platform ?? 'unknown',
                'remaining_count' => $remainingCount,
                'daily_limit' => $dailyLimit,
                'bonus_count' => $userId ? Auth::user()->bonus_parse_count : 0
            ]);

        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            Log::error('Video parsing failed: ' . $errorMessage, [
                'url' => $videoUrl,
                'user_id' => $userId,
                'ip' => $ipAddress,
                'platform' => $platform,
                'trace' => $e->getTraceAsString()
            ]);

            // 记录失败的解析尝试
            ParseLog::logParse(
                $userId,
                $ipAddress,
                $videoUrl,
                $platform,
                false,
                $errorMessage,
                null,
                $userAgent
            );

            return response()->json([
                'status' => 'error',
                'message' => __('messages.parse_failed') . ': unknown error , please contact admin' ,
                'remaining_count' => ParseLog::getRemainingCount($userId, $ipAddress)
            ], 500);
        }
    }

    /**
     * 获取用户解析状态信息
     */
    public function getParseStatus(Request $request): JsonResponse
    {
        $userId = Auth::id();
        $ipAddress = $request->ip();

        $remainingCount = ParseLog::getRemainingCount($userId, $ipAddress);
        $dailyLimit = $userId ? config('app.daily_parse_limit_user', 10) : config('app.daily_parse_limit_guest', 3);
        $usedCount = $dailyLimit - $remainingCount;

        return response()->json([
            'status' => 'success',
            'data' => [
                'is_logged_in' => (bool) $userId,
                'daily_limit' => $dailyLimit,
                'used_count' => $usedCount,
                'remaining_count' => $remainingCount,
                'is_limit_exceeded' => $remainingCount <= 0
            ]
        ]);
    }

    /**
     * 检测视频平台
     */
    private function detectPlatform(string $url): ?string
    {
        $platforms = [
            'youtube' => ['youtube.com', 'youtu.be'],
            'tiktok' => ['tiktok.com'],
            'instagram' => ['instagram.com'],
            'twitter' => ['twitter.com', 'x.com'],
            'facebook' => ['facebook.com', 'fb.com'],
            'bilibili' => ['bilibili.com'],
            'douyin' => ['douyin.com'],
            'redbook' => ['xiaohongshu.com'],

        ];

        foreach ($platforms as $platform => $domains) {
            foreach ($domains as $domain) {
                if (strpos($url, $domain) !== false) {
                    return $platform;
                }
            }
        }

        return null;
    }


    private function parseUrl($text)
    {
        $pattern = '/https?:\/\/[^\s]+/';

        preg_match($pattern, $text, $matches);

        return $matches[0] ?? '';

    }

    /**
     * 解析视频信息 (备用方法)
     */
    private function parseVideo(string $url, string $platform): array
    {
        // 备用示例数据
        return [

            'title' => '经典港片百看不厌，东莞仔凭此片终于获得了影帝！ #任贤齐 #东莞仔 #推荐电影 #电影解说 #因为一个片段看了整部剧',
            'thumbnail' => 'https://p3-sign.douyinpic.com/tos-cn-i-dy/589d1cbfbcae424a843b77c49fbd2d52~tplv-dy-resize-walign-adapt-aq:540:q75.webp?lk3s=138a59ce&x-expires=1753923600&x-signature=7Slyp8cfgLiX%2FFbsuV%2By%2B3u1u00%3D&from=327834062&s=PackSourceEnum_DOUYIN_REFLOW&se=false&sc=cover&biz_tag=aweme_video&l=20250717092534F461E36842E9B402CD32',
            'duration' => '03:45',
            'quality_options' => [
                [
                    'quality' => '1080p',
                    'format' => 'mp4',
                    'size' => '25.6 MB',
                    'download_url' => 'https://v5.douyinvod.com/9791a824f55f7a90e5a166b25b9b02dd/6878dca6/video/tos/cn/tos-cn-ve-15/osAzAAIoCEOha9qI7EvfBFAdDDqus3Q95fomSg/?a=1128&br=1091&bt=1091&btag=80008e000b5201&cd=0%7C0%7C0%7C0&ch=0&cquery=100y&cr=0&cs=0&cv=1&dr=0&ds=3&dy_q=1752747330&dy_va_biz_cert=&feature_id=fea919893f650a8c49286568590446ef&ft=kTTK4VVywfURsm80mo~pK7pswAppx27UvrKmbThcdo0g3cI&l=2025071718153078955ED2EABC4840FD81&mime_type=video_mp4&qs=0&rc=NzlmNmRlOTQ7Nzo7NGlpM0BpM3ZnNXg5cm1xNDMzNGkzM0BfL2BeMGAvXl8xMF5eMzQ1YSNlNV5vMmRrcW9hLS1kLS9zcw%3D%3D'
                ]
            ],
            'audio_options' => [
                [
                    'quality' => '320kbps',
                    'format' => 'mp3',
                    'size' => '5.2 MB',
                    'download_url' => 'https://v5.douyinvod.com/9791a824f55f7a90e5a166b25b9b02dd/6878dca6/video/tos/cn/tos-cn-ve-15/osAzAAIoCEOha9qI7EvfBFAdDDqus3Q95fomSg/?a=1128&br=1091&bt=1091&btag=80008e000b5201&cd=0%7C0%7C0%7C0&ch=0&cquery=100y&cr=0&cs=0&cv=1&dr=0&ds=3&dy_q=1752747330&dy_va_biz_cert=&feature_id=fea919893f650a8c49286568590446ef&ft=kTTK4VVywfURsm80mo~pK7pswAppx27UvrKmbThcdo0g3cI&l=2025071718153078955ED2EABC4840FD81&mime_type=video_mp4&qs=0&rc=NzlmNmRlOTQ7Nzo7NGlpM0BpM3ZnNXg5cm1xNDMzNGkzM0BfL2BeMGAvXl8xMF5eMzQ1YSNlNV5vMmRrcW9hLS1kLS9zcw%3D%3D'
                ]
            ]
            ];
    }
}
