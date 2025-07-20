<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'referral_code',
        'pending_referral_code',
        'bonus_parse_count',
        'total_referrals',
        'google_id',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * 生成推荐码
     */
    public function generateReferralCode(): string
    {
        do {
            $code = strtoupper(substr(md5(uniqid()), 0, 8));
        } while (self::where('referral_code', $code)->exists());
        
        $this->update(['referral_code' => $code]);
        return $code;
    }

    /**
     * 获取推荐码
     */
    public function getReferralCode(): string
    {
        if (!$this->referral_code) {
            return $this->generateReferralCode();
        }
        return $this->referral_code;
    }

    /**
     * 获取推荐的用户
     */
    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    /**
     * 获取推荐人
     */
    public function referrer()
    {
        return $this->hasOne(Referral::class, 'referred_user_id');
    }

    /**
     * 增加奖励解析次数
     */
    public function addBonusParseCount(int $count = 20): void
    {
        $this->increment('bonus_parse_count', $count);
        $this->increment('total_referrals');
    }

    /**
     * 使用奖励解析次数
     */
    public function useBonusParseCount(int $count = 1): bool
    {
        if ($this->bonus_parse_count >= $count) {
            $this->decrement('bonus_parse_count', $count);
            return true;
        }
        return false;
    }

    /**
     * 获取今日总解析次数限制（包括奖励次数）
     */
    public function getTotalDailyLimit(): int
    {
        $baseLimit = (int) config('app.daily_parse_limit_user', 10);
        return $baseLimit + $this->bonus_parse_count;
    }

    /**
     * 发送邮箱验证通知
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }

    /**
     * 处理待处理的推荐码
     */
    public function processPendingReferral(): bool
    {
        if (!$this->pending_referral_code) {
            return false;
        }

        // 查找推荐人
        $referrer = User::where('referral_code', $this->pending_referral_code)->first();
        
        if ($referrer && $referrer->id !== $this->id) {
            // 创建推荐记录
            Referral::create([
                'referrer_id' => $referrer->id,
                'referred_user_id' => $this->id,
                'referral_code' => $this->pending_referral_code,
                'bonus_awarded' => true,
            ]);

            // 给推荐人增加20次解析机会
            $referrer->addBonusParseCount(20);

            // 清除待处理的推荐码
            $this->update(['pending_referral_code' => null]);

            return true;
        }

        // 如果推荐码无效，也清除它
        $this->update(['pending_referral_code' => null]);
        return false;
    }
}
