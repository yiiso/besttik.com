<?php

namespace App\Service;

use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
class BlibliService
{
    public function parseVideoFromAPI($videoUrl)
    {
        $demo = 'https://www.bilibili.com/video/BV1EvuBzjEpt/?spm_id_from=333.1007.tianma.1-2-2.click';

        $path = parse_url($videoUrl,PHP_URL_PATH);
        $segments = explode('/',trim($path,'/'));

        $videoKey = array_search('video', $segments);
        if ($videoKey !== false && isset($segments[$videoKey + 1])) {
            $videoId = $segments[$videoKey + 1];
            $realUrl = env('PARSER_BLIBLI_URL').'/api/bilibili/web/fetch_one_video?bv_id='.$videoId;

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

            $cid = $data['data']['data']['cid'] ?? null;
            if ($cid) {
                $demo = 'http://31.97.122.212:3001/api/bilibili/web/fetch_video_playurl?bv_id=BV1EvuBzjEpt&cid=31032411661';
                $api = env('PARSER_BLIBLI_URL')."/api/bilibili/web/fetch_video_playurl?bv_id={$videoId}&cid={$cid}";

                $ch = curl_init();
                curl_setopt_array($ch, [
                    CURLOPT_URL => $api,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPHEADER => [
                        'Accept: application/json',
                        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36',
                    ],
                    CURLOPT_TIMEOUT => 30,
                ]);

                $res = curl_exec($ch);
                curl_close($ch);
                $video = json_decode($res,true);

                return $this->formatResponse($data['data']['data'] ?? [],$video['data']['data'] ?? []);
            }


        }
        throw new \Exception('error: ' . ($data['message'] ?? 'unknown'));

    }

    private function formatResponse(array $data,array $video): array
    {
        $formatted = [
            'title' => $data['title'] ?? $data['desc'] ?? __('messages.unknown_title'),
            'thumbnail' => $data['pic'] ?? '',
            'duration' => $data['duration'] ?? __('messages.unknown_duration'),
            'author' => isset($data['owner']) ? ($data['owner']['name'] ??  '') : __('messages.unknown_author'),
            'quality_options' => [],
            'audio_options' => []
        ];

        Log::info('VIDEO',$video);
        // 处理视频下载链接 - 尝试多种可能的字段名
        $videoUrl = $video['dash']['video'][0]['backupUrl'][0] ??   null;
        if ($videoUrl) {
            $formatted['quality_options'][] = [
                'quality' => __('messages.original_quality'),
                'format' => 'mp4',
                'size' =>    0,
                'download_url' => $videoUrl
            ];
        }

        // 处理音频下载链接
        if (isset($video['dash']['audio'][0]['backupUrl'][0])) {
            $formatted['audio_options'][] = [
                'quality' => __('messages.original_audio_quality'),
                'format' => 'mp3',
                'size' => $video['audio_size'] ?? 0,
                'download_url' => $video['dash']['audio'][0]['backupUrl'][0]
            ];
        }
        return $formatted;
    }


}
