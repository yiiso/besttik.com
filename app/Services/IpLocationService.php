<?php

namespace App\Services;

use IP2Location\Database;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class IpLocationService
{
    private $database;

    public function __construct()
    {
        // 初始化IP2Location数据库
        // 你需要下载IP2Location数据库文件并放在storage/app/ip2location/目录下
        $dbPath = storage_path('app/ip2location/IP2LOCATION-LITE-DB1.BIN');

        if (file_exists($dbPath)) {
            $this->database = new Database($dbPath, Database::FILE_IO);
        }
    }

    /**
     * 获取IP地址的位置信息
     */
    public function getLocation(string $ip): array
    {
        // 检查是否为本地IP
        if ($this->isLocalIp($ip)) {
            return [
                'country' => '本地',
                'region' => '本地',
                'city' => '本地',
                'country_code' => 'LOCAL',
                'latitude' => null,
                'longitude' => null,
                'timezone' => null,
                'isp' => '本地网络'
            ];
        }

        // 使用缓存避免重复查询
        $cacheKey = 'ip_location_' . $ip;

        return Cache::remember($cacheKey, 3600, function () use ($ip) {
            return $this->queryLocation($ip);
        });
    }

    /**
     * 查询IP位置信息
     */
    private function queryLocation(string $ip): array
    {
        $defaultResult = [
            'country' => '未知',
            'region' => '未知',
            'city' => '未知',
            'country_code' => 'UNKNOWN',
            'latitude' => null,
            'longitude' => null,
            'timezone' => null,
            'isp' => '未知'
        ];

        try {

            $ip2region = new \Ip2Region();
            $addressInfo = $ip2region->memorySearch($ip);

            $record = explode('|',$addressInfo['region'] ?? '');

            if ($record) {
                return [
                    'country' => $record[0] ?? '未知',
                    'region' => $record[2] ?? '未知',
                    'city' => $record[3] ?? '未知',
                    'country_code' => $record['countryCode'] ?? 'UNKNOWN',
                    'latitude' => $record['latitude'] ?? null,
                    'longitude' => $record['longitude'] ?? null,
                    'timezone' => $record['timeZone'] ?? null,
                    'isp' => $record[4] ?? '未知'
                ];
            }

            return $defaultResult;
        } catch (\Exception $e) {
            Log::warning('IP地址解析失败', ['ip' => $ip, 'error' => $e->getMessage()]);
            return $defaultResult;
        }
    }

    /**
     * 使用在线API查询IP位置（备用方案）
     */
    private function queryOnlineApi(string $ip): array
    {
        try {
            throw new \Exception('no query online ip');
            // 使用免费的IP API服务
            $response = file_get_contents("http://ip-api.com/json/{$ip}?fields=status,country,regionName,city,countryCode,lat,lon,timezone,isp");

            if ($response) {
                $data = json_decode($response, true);

                if ($data && $data['status'] === 'success') {
                    return [
                        'country' => $data['country'] ?: '未知',
                        'region' => $data['regionName'] ?: '未知',
                        'city' => $data['city'] ?: '未知',
                        'country_code' => $data['countryCode'] ?: 'UNKNOWN',
                        'latitude' => $data['lat'] ?: null,
                        'longitude' => $data['lon'] ?: null,
                        'timezone' => $data['timezone'] ?: null,
                        'isp' => $data['isp'] ?: '未知'
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::warning('在线IP API查询失败', ['ip' => $ip, 'error' => $e->getMessage()]);
        }

        return [
            'country' => '未知',
            'region' => '未知',
            'city' => '未知',
            'country_code' => 'UNKNOWN',
            'latitude' => null,
            'longitude' => null,
            'timezone' => null,
            'isp' => '未知'
        ];
    }

    /**
     * 检查是否为本地IP
     */
    private function isLocalIp(string $ip): bool
    {
        return in_array($ip, ['127.0.0.1', '::1', 'localhost']) ||
               filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;
    }

    /**
     * 格式化位置信息为字符串
     */
    public function formatLocation(array $location): string
    {
        $parts = [];

        if ($location['country'] && $location['country'] !== '未知') {
            $parts[] = $location['country'];
        }

        if ($location['region'] && $location['region'] !== '未知' && $location['region'] !== $location['country']) {
            $parts[] = $location['region'];
        }

        if ($location['city'] && $location['city'] !== '未知' && $location['city'] !== $location['region']) {
            $parts[] = $location['city'];
        }

        return implode(' - ', $parts) ?: '未知位置';
    }

    /**
     * 批量获取IP位置信息
     */
    public function getBatchLocations(array $ips): array
    {
        $results = [];

        foreach ($ips as $ip) {
            $results[$ip] = $this->getLocation($ip);
        }

        return $results;
    }
}
