<?php

namespace App\Service;

use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
class DouyinService
{
    public function parseVideoFromAPI(string $videoUrl): array
    {
        $realUrl = env('PARSER_DOUYIN_URL').'/video/share/url/parse?url='.urlencode($videoUrl);
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $realUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36',
            ],
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('API响应格式错误: ' . json_last_error_msg());
        }

        // 记录原始响应用于调试
        Log::info('Raw API Response: ', ['raw_response' => $response]);
        Log::info('Parsed API Response: ', ['parsed_response' => $data]);


        // 如果API返回了错误状态
        if (isset($data['status']) && $data['status'] === 'error') {
            throw new \Exception('API返回错误: ' . ($data['message'] ?? '未知错误'));
        }

        // 如果没有status字段，直接使用整个响应数据
        return $this->formatApiResponse($data['data'] ?? []);
    }

    private function formatApiResponse(array $data): array
    {

        // 根据API实际返回格式进行调整
        $formatted = [
            'title' => $data['title'] ?? $data['desc'] ?? __('messages.unknown_title'),
            'thumbnail' => $data['cover_url'] ?? $data['cover'] ?? $data['thumbnail'] ?? '',
            'duration' => $data['duration'] ?? __('messages.unknown_duration'),
            'author' => isset($data['author']) ? ($data['author']['name'] ?? $data['author']) : __('messages.unknown_author'),
            'quality_options' => [],
            'audio_options' => []
        ];

        // 处理视频下载链接 - 尝试多种可能的字段名
        $videoUrl = $data['video_url'] ?? $data['download_url'] ?? $data['url'] ?? $data['play_url'] ?? null;
        if ($videoUrl) {
            $formatted['quality_options'][] = [
                'quality' => __('messages.original_quality'),
                'format' => 'mp4',
                'size' => $data['size'] ?? 0,
                'download_url' => $videoUrl
            ];
        }

        // 处理音频下载链接
        if (isset($data['music_url'])) {
            $formatted['audio_options'][] = [
                'quality' => __('messages.original_audio_quality'),
                'format' => 'mp3',
                'size' => $data['audio_size'] ?? 0,
                'download_url' => $data['music_url']
            ];
        }

        return $formatted;
    }


}
