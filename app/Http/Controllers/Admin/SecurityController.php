<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminLoginThrottleService;
use App\Services\IpLocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class SecurityController extends Controller
{
    protected $throttleService;
    protected $ipLocationService;

    public function __construct(AdminLoginThrottleService $throttleService, IpLocationService $ipLocationService)
    {
        $this->throttleService = $throttleService;
        $this->ipLocationService = $ipLocationService;
    }

    /**
     * 显示安全监控页面
     */
    public function index()
    {
        return view('admin.security');
    }

    /**
     * 获取登录统计数据
     */
    public function getLoginStats()
    {
        $today = Carbon::today();

        // 获取今日失败尝试
        $failedAttempts = $this->throttleService->getTodayFailedAttempts();

        // 统计独立IP数量
        $uniqueIps = collect($failedAttempts)->pluck('ip')->unique()->count();

        // 统计涉及邮箱数量
        $uniqueEmails = collect($failedAttempts)->pluck('email')->unique()->count();

        // 按小时统计失败尝试
        $attemptsByHour = array_fill(0, 24, 0);


        return response()->json([
            'total_attempts' => count($failedAttempts),
            'unique_ips' => $uniqueIps,
            'unique_emails' => $uniqueEmails,
            'attempts_by_hour' => $failedAttempts['attempts_by_hour'],
            'last_update' => now()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * 获取异常IP详细列表
     */
    public function getAbnormalIps(Request $request)
    {
        $dateRange = $request->get('range', 'today');
        $minAttempts = $request->get('min_attempts', 3); // 最少失败次数才算异常

        $failedAttempts = $this->throttleService->getRangeDayFailedAttempts($dateRange);

        // 按IP分组统计
        $ipStats = collect($failedAttempts)
            ->groupBy('ip')
            ->map(function ($attempts, $ip) {
                return [
                    'ip' => $ip,
                    'attempts' => $attempts->count(),
                    'emails' => $attempts->pluck('email')->unique()->values(),
                    'first_attempt' => $attempts->min('time'),
                    'last_attempt' => $attempts->max('time'),
                    'user_agents' => $attempts->pluck('user_agent')->unique()->values()
                ];
            })
            ->filter(function ($stat) use ($minAttempts) {
                return $stat['attempts'] >= $minAttempts;
            })
            ->sortByDesc('attempts')
            ->values();

        // 获取IP位置信息
        $ips = $ipStats->pluck('ip')->toArray();
        $locations = $this->ipLocationService->getBatchLocations($ips);

        // 合并位置信息
        $ipStats = $ipStats->map(function ($stat) use ($locations) {
            $location = $locations[$stat['ip']] ?? [];
            $stat['location'] = $location;
            $stat['location_text'] = $this->ipLocationService->formatLocation($location);
            return $stat;
        });

        return response()->json([
            'abnormal_ips' => $ipStats,
            'total_count' => $ipStats->count(),
            'date_range' => $dateRange,
            'min_attempts' => $minAttempts
        ]);
    }

    /**
     * 获取异常邮箱详细列表
     */
    public function getAbnormalEmails(Request $request)
    {
        $dateRange = $request->get('range', 'today');
        $minAttempts = $request->get('min_attempts', 3);

        $failedAttempts = $this->throttleService->getRangeDayFailedAttempts($dateRange);

        // 按邮箱分组统计
        $emailStats = collect($failedAttempts)
            ->groupBy('email')
            ->map(function ($attempts, $email) {
                return [
                    'email' => $email,
                    'attempts' => $attempts->count(),
                    'ips' => $attempts->pluck('ip')->unique()->values(),
                    'first_attempt' => $attempts->min('time'),
                    'last_attempt' => $attempts->max('time'),
                    'user_agents' => $attempts->pluck('user_agent')->unique()->values()
                ];
            })
            ->filter(function ($stat) use ($minAttempts) {
                return $stat['attempts'] >= $minAttempts;
            })
            ->sortByDesc('attempts')
            ->values();

        // 获取相关IP的位置信息
        $allIps = $emailStats->flatMap(function ($stat) {
            return $stat['ips'];
        })->unique()->toArray();

        $locations = $this->ipLocationService->getBatchLocations($allIps);

        // 为每个邮箱添加IP位置信息
        $emailStats = $emailStats->map(function ($stat) use ($locations) {
            $stat['ip_locations'] = collect($stat['ips'])->map(function ($ip) use ($locations) {
                $location = $locations[$ip] ?? [];
                return [
                    'ip' => $ip,
                    'location_text' => $this->ipLocationService->formatLocation($location)
                ];
            })->toArray();
            return $stat;
        });

        return response()->json([
            'abnormal_emails' => $emailStats,
            'total_count' => $emailStats->count(),
            'date_range' => $dateRange,
            'min_attempts' => $minAttempts
        ]);
    }

    /**
     * 紧急解锁账户
     */
    public function unlock(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'ip' => 'required|ip'
        ]);

        $email = $request->email;
        $ip = $request->ip;

        try {
            // 解锁邮箱
            $this->throttleService->clearEmailThrottle($email);

            // 解锁IP
            $this->throttleService->clearIpThrottle($ip);

            // 记录解锁操作
            \Log::info('管理员紧急解锁', [
                'admin_id' => auth('admin')->id(),
                'admin_email' => auth('admin')->user()->email,
                'unlocked_email' => $email,
                'unlocked_ip' => $ip,
                'time' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => '解锁成功'
            ]);
        } catch (\Exception $e) {
            \Log::error('解锁失败', [
                'email' => $email,
                'ip' => $ip,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => '解锁失败: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 获取实时安全状态
     */
    public function getSecurityStatus()
    {
        $cacheKey = 'admin_security_status';

        return Cache::remember($cacheKey, 60, function () {
            $failedAttempts = $this->throttleService->getTodayFailedAttempts();

            // 计算风险等级
            $totalAttempts = count($failedAttempts);
            $uniqueIps = collect($failedAttempts)->pluck('ip')->unique()->count();

            $riskLevel = 'low';
            if ($totalAttempts > 50 || $uniqueIps > 20) {
                $riskLevel = 'high';
            } elseif ($totalAttempts > 20 || $uniqueIps > 10) {
                $riskLevel = 'medium';
            }

            // 最近的攻击
            $recentAttacks = collect($failedAttempts)
                ->sortByDesc('time')
                ->take(5)
                ->map(function ($attempt) {
                    $location = $this->ipLocationService->getLocation($attempt['ip']);
                    return [
                        'ip' => $attempt['ip'],
                        'email' => $attempt['email'],
                        'time' => $attempt['time'],
                        'location' => $this->ipLocationService->formatLocation($location)
                    ];
                })
                ->values();

            return [
                'risk_level' => $riskLevel,
                'total_attempts' => $totalAttempts,
                'unique_ips' => $uniqueIps,
                'recent_attacks' => $recentAttacks,
                'last_update' => now()->format('Y-m-d H:i:s')
            ];
        });
    }
}
