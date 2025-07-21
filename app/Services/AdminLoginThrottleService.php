<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request;

class AdminLoginThrottleService
{
    // 最大尝试次数
    const MAX_ATTEMPTS = 3;
    
    // 锁定时间（秒）
    const LOCKOUT_TIME = 900; // 15分钟
    
    // 尝试记录过期时间（秒）
    const ATTEMPT_EXPIRE_TIME = 3600; // 1小时
    
    /**
     * 获取IP地址的Redis键
     */
    private function getIpKey(string $ip): string
    {
        return "admin_login_attempts:ip:{$ip}";
    }
    
    /**
     * 获取邮箱的Redis键
     */
    private function getEmailKey(string $email): string
    {
        return "admin_login_attempts:email:" . md5($email);
    }
    
    /**
     * 获取锁定状态的Redis键
     */
    private function getLockoutKey(string $identifier): string
    {
        return "admin_login_lockout:{$identifier}";
    }
    
    /**
     * 记录失败的登录尝试
     */
    public function recordFailedAttempt(string $email, string $ip): void
    {
        $ipKey = $this->getIpKey($ip);
        $emailKey = $this->getEmailKey($email);
        
        // 增加IP尝试次数
        $ipAttempts = Redis::incr($ipKey);
        Redis::expire($ipKey, self::ATTEMPT_EXPIRE_TIME);
        
        // 增加邮箱尝试次数
        $emailAttempts = Redis::incr($emailKey);
        Redis::expire($emailKey, self::ATTEMPT_EXPIRE_TIME);
        
        // 检查是否需要锁定
        if ($ipAttempts >= self::MAX_ATTEMPTS) {
            $this->lockoutIdentifier($ip, 'ip');
        }
        
        if ($emailAttempts >= self::MAX_ATTEMPTS) {
            $this->lockoutIdentifier(md5($email), 'email');
        }
        
        // 记录详细的尝试信息
        $this->logAttempt($email, $ip, $ipAttempts, $emailAttempts);
    }
    
    /**
     * 锁定标识符
     */
    private function lockoutIdentifier(string $identifier, string $type): void
    {
        $lockoutKey = $this->getLockoutKey($identifier);
        Redis::setex($lockoutKey, self::LOCKOUT_TIME, json_encode([
            'type' => $type,
            'locked_at' => now()->toISOString(),
            'unlock_at' => now()->addSeconds(self::LOCKOUT_TIME)->toISOString()
        ]));
    }
    
    /**
     * 检查IP是否被锁定
     */
    public function isIpLocked(string $ip): bool
    {
        $lockoutKey = $this->getLockoutKey($ip);
        return Redis::exists($lockoutKey);
    }
    
    /**
     * 检查邮箱是否被锁定
     */
    public function isEmailLocked(string $email): bool
    {
        $lockoutKey = $this->getLockoutKey(md5($email));
        return Redis::exists($lockoutKey);
    }
    
    /**
     * 检查是否被锁定（IP或邮箱任一被锁定都不能登录）
     */
    public function isLocked(string $email, string $ip): bool
    {
        return $this->isIpLocked($ip) || $this->isEmailLocked($email);
    }
    
    /**
     * 获取剩余锁定时间
     */
    public function getRemainingLockoutTime(string $email, string $ip): int
    {
        $ipLockoutKey = $this->getLockoutKey($ip);
        $emailLockoutKey = $this->getLockoutKey(md5($email));
        
        $ipTtl = Redis::ttl($ipLockoutKey);
        $emailTtl = Redis::ttl($emailLockoutKey);
        
        // 返回较长的锁定时间
        return max($ipTtl > 0 ? $ipTtl : 0, $emailTtl > 0 ? $emailTtl : 0);
    }
    
    /**
     * 获取当前尝试次数
     */
    public function getAttempts(string $email, string $ip): array
    {
        $ipKey = $this->getIpKey($ip);
        $emailKey = $this->getEmailKey($email);
        
        $ipAttempts = Redis::get($ipKey) ?: 0;
        $emailAttempts = Redis::get($emailKey) ?: 0;
        
        return [
            'ip_attempts' => (int)$ipAttempts,
            'email_attempts' => (int)$emailAttempts,
            'remaining_attempts' => max(0, self::MAX_ATTEMPTS - max($ipAttempts, $emailAttempts))
        ];
    }
    
    /**
     * 清除成功登录后的尝试记录
     */
    public function clearAttempts(string $email, string $ip): void
    {
        $ipKey = $this->getIpKey($ip);
        $emailKey = $this->getEmailKey($email);
        $ipLockoutKey = $this->getLockoutKey($ip);
        $emailLockoutKey = $this->getLockoutKey(md5($email));
        
        Redis::del([$ipKey, $emailKey, $ipLockoutKey, $emailLockoutKey]);
    }
    
    /**
     * 记录尝试详情（用于监控和分析）
     */
    private function logAttempt(string $email, string $ip, int $ipAttempts, int $emailAttempts): void
    {
        $logKey = "admin_login_attempt_log:" . date('Y-m-d');
        $logData = [
            'timestamp' => now()->toISOString(),
            'email' => $email,
            'ip' => $ip,
            'ip_attempts' => $ipAttempts,
            'email_attempts' => $emailAttempts,
            'user_agent' => Request::header('User-Agent'),
        ];
        
        Redis::lpush($logKey, json_encode($logData));
        Redis::expire($logKey, 86400 * 7); // 保留7天
    }
    
    /**
     * 获取锁定信息
     */
    public function getLockoutInfo(string $email, string $ip): ?array
    {
        $ipLockoutKey = $this->getLockoutKey($ip);
        $emailLockoutKey = $this->getLockoutKey(md5($email));
        
        $ipLockout = Redis::get($ipLockoutKey);
        $emailLockout = Redis::get($emailLockoutKey);
        
        if ($ipLockout) {
            $data = json_decode($ipLockout, true);
            $data['remaining_time'] = Redis::ttl($ipLockoutKey);
            $data['reason'] = 'IP地址被锁定';
            return $data;
        }
        
        if ($emailLockout) {
            $data = json_decode($emailLockout, true);
            $data['remaining_time'] = Redis::ttl($emailLockoutKey);
            $data['reason'] = '邮箱被锁定';
            return $data;
        }
        
        return null;
    }
    
    /**
     * 管理员手动解锁（紧急情况使用）
     */
    public function unlock(string $email, string $ip): void
    {
        $this->clearAttempts($email, $ip);
    }
    
    /**
     * 获取今日失败尝试统计
     */
    public function getTodayFailedAttempts(): array
    {
        $logKey = "admin_login_attempt_log:" . date('Y-m-d');
        $logs = Redis::lrange($logKey, 0, -1);
        
        $stats = [
            'total_attempts' => count($logs),
            'unique_ips' => [],
            'unique_emails' => [],
            'attempts_by_hour' => array_fill(0, 24, 0)
        ];
        
        foreach ($logs as $log) {
            $data = json_decode($log, true);
            if ($data) {
                $stats['unique_ips'][$data['ip']] = true;
                $stats['unique_emails'][$data['email']] = true;
                
                $hour = (int)date('H', strtotime($data['timestamp']));
                $stats['attempts_by_hour'][$hour]++;
            }
        }
        
        $stats['unique_ips'] = count($stats['unique_ips']);
        $stats['unique_emails'] = count($stats['unique_emails']);
        
        return $stats;
    }
}