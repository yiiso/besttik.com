<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class VideoParserController extends Controller
{
    /**
     * 解析视频链接
     */
    public function parse(Request $request): JsonResponse
    {
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

        try {
            // 检测视频平台
            $platform = $this->detectPlatform($videoUrl);

            // 调用外部解析API
//            $videInfo = $this->parseVideoFromAPI($videoUrl);
            $videoInfo = $this->parseVideo($videoUrl,'douyin');

            return response()->json([
                'status' => 'success',
                'data' => $videoInfo,
                'platform' => $platform ?? 'unknown'
            ]);

        } catch (\Exception $e) {
            \Log::error('Video parsing failed: ' . $e->getMessage(), [
                'url' => $videoUrl,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => '解析失败：' . $e->getMessage()
            ], 500);
        }
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
            'douyin' => ['douyin.com']
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

    /**
     * 调用外部解析API
     */
    private function parseVideoFromAPI(string $videoUrl): array
    {
        $apiUrl = 'https://douyindown.click/parser.php';

        // 构建请求参数
        $params = [
            'url' => $videoUrl
        ];

        // 初始化cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl . '?' . http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \Exception('网络请求失败: ' . $error);
        }

        if ($httpCode !== 200) {
            throw new \Exception('API请求失败，状态码: ' . $httpCode);
        }

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('API响应格式错误: ' . json_last_error_msg());
        }

        // 记录原始响应用于调试
        \Log::info('Raw API Response: ', ['raw_response' => $response]);
        \Log::info('Parsed API Response: ', ['parsed_response' => $data]);

        // 检查API响应格式并处理
        if (!$data) {
            throw new \Exception('API返回空数据');
        }

        // 如果API返回了错误状态
        if (isset($data['status']) && $data['status'] === 'error') {
            throw new \Exception('API返回错误: ' . ($data['message'] ?? '未知错误'));
        }

        // 如果API返回了成功状态，使用data字段
        if (isset($data['status']) && $data['status'] === 'success' && isset($data['data'])) {
            return $this->formatApiResponse($data['data']);
        }

        // 如果没有status字段，直接使用整个响应数据
        return $this->formatApiResponse($data['data']);
    }

    /**
     * 格式化API响应数据
     */
    private function formatApiResponse(array $data): array
    {
        // 记录数据结构用于调试
        \Log::info('Formatting API Response: ', ['data_keys' => array_keys($data)]);

        // 根据API实际返回格式进行调整
        $formatted = [
            'title' => $data['title'] ?? $data['desc'] ?? '未知标题',
            'thumbnail' => $data['cover_url'] ?? $data['cover'] ?? $data['thumbnail'] ?? '',
            'duration' => $data['duration'] ?? '未知',
            'author' => isset($data['author']) ? ($data['author']['name'] ?? $data['author']) : '未知作者',
            'quality_options' => [],
            'audio_options' => []
        ];

        // 处理视频下载链接 - 尝试多种可能的字段名
        $videoUrl = $data['video_url'] ?? $data['download_url'] ?? $data['url'] ?? $data['play_url'] ?? null;
        if ($videoUrl) {
            $formatted['quality_options'][] = [
                'quality' => '原画质',
                'format' => 'mp4',
                'size' => $data['size'] ?? '未知大小',
                'download_url' => $videoUrl
            ];
        }

        // 处理音频下载链接
        if (isset($data['audio_url'])) {
            $formatted['audio_options'][] = [
                'quality' => '原音质',
                'format' => 'mp3',
                'size' => $data['audio_size'] ?? '未知大小',
                'download_url' => $data['audio_url']
            ];
        }

        // 如果没有找到视频链接，记录所有可用的字段
        if (empty($formatted['quality_options'])) {
            \Log::warning('No video URL found in API response', ['available_fields' => array_keys($data)]);
        }

        return $formatted;
    }

    /**
     * 解析视频信息 (备用方法)
     */
    private function parseVideo(string $url, string $platform): array
    {
        // 备用示例数据
        return [
            'data' => [
            'title' => '示例视频标题',
            'thumbnail' => 'https://via.placeholder.com/480x360',
            'duration' => '03:45',
            'quality_options' => [
                [
                    'quality' => '1080p',
                    'format' => 'mp4',
                    'size' => '25.6 MB',
                    'download_url' => '#'
                ]
            ],
            'audio_options' => [
                [
                    'quality' => '320kbps',
                    'format' => 'mp3',
                    'size' => '5.2 MB',
                    'download_url' => '#'
                ]
            ]
        ]
            ];
    }
}
