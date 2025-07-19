<?php

namespace App\Http\Controllers;

use App\Service\YoutubeService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class VideoParserController extends Controller
{
    /**
     * 解析视频链接
     */
    public function parse(Request $request): JsonResponse
    {

        $demo = '{
    "status": "success",
    "data": {
        "title": "Unknown Title",
        "thumbnail": "",
        "duration": "Unknown Duration",
        "author": "Unknown Author",
        "quality_options": [
            {
                "quality": "Original Quality",
                "format": "mp4",
                "size": 0,
                "download_url": "https:\/\/rr2---sn-4g5ednkl.googlevideo.com\/videoplayback?expire=1752945684&ei=s397aJXTPJPt6dsPmp7k4QU&ip=2a02%3A4780%3A41%3Ae81f%3A%3A1&id=o-AOldkFUoBfz6-IB-5iznKh74wOd7PYlPUtFrVPBwBh4b&itag=401&aitags=133%2C134%2C135%2C136%2C160%2C242%2C243%2C244%2C247%2C278%2C298%2C299%2C302%2C303%2C308%2C315%2C394%2C395%2C396%2C397%2C398%2C399%2C400%2C401&source=youtube&requiressl=yes&xpc=EgVo2aDSNQ%3D%3D&met=1752924084%2C&mh=2F&mm=31%2C29&mn=sn-4g5ednkl%2Csn-4g5lzned&ms=au%2Crdu&mv=m&mvi=2&pl=48&rms=au%2Cau&initcwndbps=298750&siu=1&bui=AY1jyLOeXQS0pbYR23vWmYgu4EQtsbVbC85k_a2HWbCR3giO1DslQzLIRyOvI8b9dPrOV5EVcw&vprv=1&svpuc=1&mime=video%2Fmp4&ns=JNY3WLGAYvF3cpjrljUV4b0Q&rqh=1&gir=yes&clen=8798267510&dur=8890.282&lmt=1750678624860429&mt=1752923602&fvip=2&keepalive=yes&lmw=1&fexp=51543008&c=TVHTML5&sefc=1&txp=4532534&n=KkAjbMNPnv64AA&sparams=expire%2Cei%2Cip%2Cid%2Caitags%2Csource%2Crequiressl%2Cxpc%2Csiu%2Cbui%2Cvprv%2Csvpuc%2Cmime%2Cns%2Crqh%2Cgir%2Cclen%2Cdur%2Clmt&sig=AJfQdSswRQIhAOS8LnDtU4_Mq_qQlmmRqYRaNQ_mV4qEM-B-V9aqeKxCAiBjr1x5yTr0rJjHJd0SJHHLvlcqZPf0IVsMIggrEz5nCg%3D%3D&lsparams=met%2Cmh%2Cmm%2Cmn%2Cms%2Cmv%2Cmvi%2Cpl%2Crms%2Cinitcwndbps&lsig=APaTxxMwRQIhAKRLDcbCgf7D_zVo7O2FFrRaZ-n7TnTVSDhfL7A4xGmnAiBhxNjQgtqKyGDVb3nF0PBP1NyYmmAlZ1ZZjlXJ0Jkhdg%3D%3D"
            }
        ],
        "audio_options": [
            {
                "quality": "messages.original_audio_quality",
                "format": "mp3",
                "size": 0,
                "download_url": "https:\/\/rr2---sn-4g5ednkl.googlevideo.com\/videoplayback?expire=1752945684&ei=s397aJXTPJPt6dsPmp7k4QU&ip=2a02%3A4780%3A41%3Ae81f%3A%3A1&id=o-AOldkFUoBfz6-IB-5iznKh74wOd7PYlPUtFrVPBwBh4b&itag=251&source=youtube&requiressl=yes&xpc=EgVo2aDSNQ%3D%3D&met=1752924084%2C&mh=2F&mm=31%2C29&mn=sn-4g5ednkl%2Csn-4g5lzned&ms=au%2Crdu&mv=m&mvi=2&pl=48&rms=au%2Cau&initcwndbps=298750&siu=1&bui=AY1jyLOeXQS0pbYR23vWmYgu4EQtsbVbC85k_a2HWbCR3giO1DslQzLIRyOvI8b9dPrOV5EVcw&vprv=1&svpuc=1&mime=audio%2Fwebm&ns=JNY3WLGAYvF3cpjrljUV4b0Q&rqh=1&gir=yes&clen=146530005&dur=8890.321&lmt=1750508590044995&mt=1752923602&fvip=2&keepalive=yes&lmw=1&fexp=51543008&c=TVHTML5&sefc=1&txp=4532534&n=KkAjbMNPnv64AA&sparams=expire%2Cei%2Cip%2Cid%2Citag%2Csource%2Crequiressl%2Cxpc%2Csiu%2Cbui%2Cvprv%2Csvpuc%2Cmime%2Cns%2Crqh%2Cgir%2Cclen%2Cdur%2Clmt&sig=AJfQdSswRQIgOLUD6dx9E7t2V6W-hVWeccaBhanJdh2hFFxE4aiB6bYCIQDbLldbNy47JtoY2DdAXMsIQsHXqx-6NiBAtaDmXmUO1g%3D%3D&lsparams=met%2Cmh%2Cmm%2Cmn%2Cms%2Cmv%2Cmvi%2Cpl%2Crms%2Cinitcwndbps&lsig=APaTxxMwRQIhAKRLDcbCgf7D_zVo7O2FFrRaZ-n7TnTVSDhfL7A4xGmnAiBhxNjQgtqKyGDVb3nF0PBP1NyYmmAlZ1ZZjlXJ0Jkhdg%3D%3D"
            }
        ]
    },
    "platform": "youtube"
}';

        return response()->json([
            'status' => 'success',
            'data' => json_decode($demo,true)['data'] ?? [],
            'platform' => $platform ?? 'unknown'
        ]);

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


            if ($platform == 'tiktok'){
                $videoInfo = $this->tikTokParseVideoFromAPI($videoUrl);
            }elseif($platform == 'bilibili'){
                $videoInfo = $this->blibliParseVideoFromAPI($videoUrl);
            }elseif($platform =='youtube'){
                $cookiePath = '/www/wwwroot/videoparser.top/storage/youtube-cookies.txt';
                $format = 'bestvideo+bestaudio';
                $videoInfo = (new YoutubeService())->getVideoUrl($videoUrl,$format,$cookiePath);
            }else{
                $videoInfo = $this->parseVideoFromAPI($videoUrl);
            }
            // 调用外部解析API

//           $videoInfo = $this->parseVideo($videoUrl,'douyin');

            return response()->json([
                'status' => 'success',
                'data' => $videoInfo,
                'platform' => $platform ?? 'unknown'
            ]);

        } catch (\Exception $e) {
            Log::error('Video parsing failed: ' . $e->getMessage(), [
                'url' => $videoUrl,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => __('messages.parse_failed') . ': ' . $e->getMessage()
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



    private function blibliParseVideoFromAPI($videoUrl)
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

                return $this->blibliTiktokResponse($data['data']['data'] ?? [],$video['data']['data'] ?? []);
            }


        }
        throw new \Exception('error: ' . ($data['message'] ?? 'unknown'));

    }
    private function tiktokParseVideoFromAPI($videoUrl)
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

            return $this->formatTiktokResponse($data['data'] ?? []);
        }
        throw new \Exception('error: ' . ($data['message'] ?? 'unknown'));

    }

    /**
     * 调用外部解析API
     */
    private function parseVideoFromAPI(string $videoUrl): array
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



    private function blibliTiktokResponse(array $data,array $video): array
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
    private function formatTiktokResponse(array $data): array
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

    /**
     * 格式化API响应数据
     */
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
