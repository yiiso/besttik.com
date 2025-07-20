<?php

namespace App\Http\Controllers;

use App\Models\ParseLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    /**
     * 获取用户仪表板数据
     */
    public function getDashboardData(): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // 今日已使用次数
        $todayUsed = ParseLog::getTodaySuccessCountByUser($user->id);
        
        // 基础每日限制
        $baseLimit = (int) config('app.daily_parse_limit_user', 10);
        
        // 总限制（基础 + 奖励）
        $totalLimit = $user->getTotalDailyLimit();
        
        // 剩余次数
        $remaining = max(0, $totalLimit - $todayUsed);

        // 本周解析统计
        $weeklyStats = $this->getWeeklyStats($user->id);

        return response()->json([
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'total_referrals' => $user->total_referrals,
            ],
            'parse_stats' => [
                'today_used' => $todayUsed,
                'base_daily_limit' => $baseLimit,
                'bonus_parse_count' => $user->bonus_parse_count,
                'total_daily_limit' => $totalLimit,
                'remaining_today' => $remaining,
            ],
            'weekly_stats' => $weeklyStats,
            'referral' => [
                'code' => $user->getReferralCode(),
                'link' => url('/?ref=' . $user->getReferralCode()),
                'total_referrals' => $user->total_referrals,
                'bonus_earned' => $user->total_referrals * 20,
            ]
        ]);
    }

    /**
     * 获取本周解析统计
     */
    private function getWeeklyStats(int $userId): array
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $stats = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $count = ParseLog::where('user_id', $userId)
                ->where('parse_date', $date->toDateString())
                ->where('is_success', true)
                ->count();

            $stats[] = [
                'date' => $date->toDateString(),
                'day' => $date->format('D'),
                'count' => $count,
            ];
        }

        return $stats;
    }
}