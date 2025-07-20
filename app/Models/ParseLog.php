<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class ParseLog extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'video_url',
        'platform',
        'is_success',
        'error_message',
        'parse_result',
        'user_agent',
        'parse_date',
    ];

    protected $casts = [
        'is_success' => 'boolean',
        'parse_result' => 'array',
        'parse_date' => 'date',
    ];

    /**
     * 关联用户
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 获取今日某IP的成功解析次数
     */
    public static function getTodaySuccessCountByIp(string $ip): int
    {
        return static::where('ip_address', $ip)
            ->where('parse_date', Carbon::today())
            ->where('is_success', true)
            ->count();
    }

    /**
     * 获取今日某用户的成功解析次数
     */
    public static function getTodaySuccessCountByUser(int $userId): int
    {
        return static::where('user_id', $userId)
            ->where('parse_date', Carbon::today())
            ->where('is_success', true)
            ->count();
    }

    /**
     * 记录解析日志
     */
    public static function logParse(
        ?int $userId,
        string $ip,
        string $videoUrl,
        ?string $platform,
        bool $isSuccess,
        ?string $errorMessage = null,
        ?array $parseResult = null,
        ?string $userAgent = null
    ): static {
        return static::create([
            'user_id' => $userId,
            'ip_address' => $ip,
            'video_url' => $videoUrl,
            'platform' => $platform,
            'is_success' => $isSuccess,
            'error_message' => $errorMessage,
            'parse_result' => $parseResult,
            'user_agent' => $userAgent,
            'parse_date' => Carbon::today(),
        ]);
    }

    /**
     * 检查是否超过每日限制
     */
    public static function isExceedDailyLimit(?int $userId, string $ip): bool
    {
        $guestLimit = (int) config('app.daily_parse_limit_guest', 3);
        $baseUserLimit = (int) config('app.daily_parse_limit_user', 10);

        if ($userId) {
            // 登录用户检查（包括奖励次数）
            $user = User::find($userId);
            $totalLimit = $user ? $user->getTotalDailyLimit() : $baseUserLimit;
            $todayCount = static::getTodaySuccessCountByUser($userId);
            return $todayCount >= $totalLimit;
        } else {
            // 未登录用户检查
            $todayCount = static::getTodaySuccessCountByIp($ip);
            return $todayCount >= $guestLimit;
        }
    }

    /**
     * 获取剩余解析次数
     */
    public static function getRemainingCount(?int $userId, string $ip): int
    {
        $guestLimit = (int) config('app.daily_parse_limit_guest', 3);
        $baseUserLimit = (int) config('app.daily_parse_limit_user', 10);

        if ($userId) {
            $user = User::find($userId);
            $totalLimit = $user ? $user->getTotalDailyLimit() : $baseUserLimit;
            $todayCount = static::getTodaySuccessCountByUser($userId);
            return max(0, $totalLimit - $todayCount);
        } else {
            $todayCount = static::getTodaySuccessCountByIp($ip);
            return max(0, $guestLimit - $todayCount);
        }
    }
}
