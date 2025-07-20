<?php

namespace App\Service;

use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
class ParseService
{
    public function parseVideoFromAPI($videoUrl)
    {
        $realUrl = env('PARSER_TIKTOK_URL').'/video/share/url/parse?url='.urlencode($videoUrl);
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
        return $this->formatResponse($data['data'] ?? []);

    }

    private function formatResponse(array $data): array
    {
        $formatted = [
            'title' => $data['title'] ?? $data['desc'] ?? __('messages.unknown_title'),
            'thumbnail' => $data['pic'] ?? '',
            'duration' => $data['duration'] ?? __('messages.unknown_duration'),
            'author' => isset($data['owner']) ? ($data['owner']['name'] ??  '') : __('messages.unknown_author'),
            'quality_options' => [],
            'audio_options' => []
        ];

        Log::info('VIDEO',$data);
        // 处理视频下载链接 - 尝试多种可能的字段名
        $videoUrl = $data['dash']['video'][0]['backupUrl'][0] ??   null;
        if ($videoUrl) {
            $formatted['quality_options'][] = [
                'quality' => __('messages.original_quality'),
                'format' => 'mp4',
                'size' =>    0,
                'download_url' => $videoUrl
            ];
        }

        // 处理音频下载链接
        if (isset($data['dash']['audio'][0]['backupUrl'][0])) {
            $formatted['audio_options'][] = [
                'quality' => __('messages.original_audio_quality'),
                'format' => 'mp3',
                'size' => $video['audio_size'] ?? 0,
                'download_url' => $data['dash']['audio'][0]['backupUrl'][0]
            ];
        }
        return $formatted;
    }


}
