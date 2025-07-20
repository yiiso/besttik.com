<?php

namespace App\Service;

use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
class TiktokService
{
    public function parseVideoFromAPI($videoUrl)
    {
        $demo = 'https://www.tiktok.com/@alejocroes/video/7525722589738650913?is_from_webapp=1&sender_device=pc';

        $path = parse_url($videoUrl,PHP_URL_PATH);
        $segments = explode('/',trim($path,'/'));

        $videoKey = array_search('video', $segments);
        if ($videoKey !== false && isset($segments[$videoKey + 1])) {
            $videoId = $segments[$videoKey + 1];
            $realUrl = env('PARSER_TIKTOK').'/api/tiktok/app/fetch_one_video?aweme_id='.$videoId;

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

            return $this->formatResponse($data['data'] ?? []);
        }
        throw new \Exception('error: ' . ($data['message'] ?? 'unknown'));

    }

    private function formatResponse(array $data): array
    {
        $formatted = [
            'title' => $data['title'] ?? $data['desc'] ?? __('messages.unknown_title'),
            'thumbnail' => $data['video']['cover']['url_list'][0] ?? '',
            'duration' => $data['duration'] ?? __('messages.unknown_duration'),
            'author' => isset($data['author']) ? ($data['author']['nickname'] ??  '') : __('messages.unknown_author'),
            'quality_options' => [],
            'audio_options' => []
        ];

        // 处理视频下载链接 - 尝试多种可能的字段名
        $videoUrl = $data['video']['play_addr']['url_list'][0] ??   null;
        if ($videoUrl) {
            $formatted['quality_options'][] = [
                'quality' => __('messages.original_quality'),
                'format' => 'mp4',
                'size' => number_format($data['video']['play_addr']['data_size']/1024/1024, 2) ?? 0,
                'download_url' => $videoUrl
            ];
        }

        // 处理音频下载链接
        if (isset($data['music']['play_url']['uri'])) {
            $formatted['audio_options'][] = [
                'quality' => __('messages.original_audio_quality'),
                'format' => 'mp3',
                'size' => $data['audio_size'] ?? 0,
                'download_url' => $data['music']['play_url']['uri']
            ];
        }
        return $formatted;
    }


}
