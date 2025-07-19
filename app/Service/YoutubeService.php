<?php

namespace App\Service;

use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
class YoutubeService
{
    public function getVideoUrl(string $youtubeUrl, string $format = 'bestvideo+bestaudio', string $cookiesPath = null): array
    {
 /*       $command = [
            '/www/server/pyporject_evn/versions/3.13.3/bin/yt-dlp',
            '-g', // 只返回 URL
            '-f', $format,
        ];

        if ($cookiesPath) {
            $command[] = '--cookies';
            $command[] = $cookiesPath;
        }

        $command[] = $youtubeUrl;

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        // 输出可能有两行（视频 + 音频）
        $res = array_filter(explode("\n", trim($process->getOutput())));
        return $this->formatResponse($res);*/

        $cookies = storage_path('youtube-cookies.txt');

        $cmd = "/www/server/pyporject_evn/versions/3.13.3/bin/yt-dlp -g -f {$format} --cookies {$cookies} {$youtubeUrl}";
        $res = array_filter(explode("\n", trim(shell_exec($cmd))));
        return $this->formatResponse($res);

    }

    public function formatResponse(array $data)
    {
        $formatted = [
            'title' => $data['title'] ?? $data['desc'] ?? __('messages.unknown_title'),
            'thumbnail' => $data['pic'] ?? '',
            'duration' => $data['duration'] ?? __('messages.unknown_duration'),
            'author' => isset($data['owner']) ? ($data['owner']['name'] ??  '') : __('messages.unknown_author'),
            'quality_options' => [],
            'audio_options' => []
        ];


        // 处理视频下载链接 - 尝试多种可能的字段名
        $videoUrl = $data[0] ?? null;
        if ($videoUrl) {
            $formatted['quality_options'][] = [
                'quality' => __('messages.original_quality'),
                'format' => 'mp4',
                'size' =>    0,
                'download_url' => $videoUrl
            ];
        }

        // 处理音频下载链接
        if (isset($data[1])) {
            $formatted['audio_options'][] = [
                'quality' => __('messages.original_audio_quality'),
                'format' => 'mp3',
                'size' => $video['audio_size'] ?? 0,
                'download_url' =>$data[1]
            ];
        }
        return $formatted;
    }
}
