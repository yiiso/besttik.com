<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    /**
     * 获取用户的推荐链接
     */
    public function getReferralLink(): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $referralCode = $user->getReferralCode();
        $referralLink = url('/?ref=' . $referralCode);

        return response()->json([
            'referral_code' => $referralCode,
            'referral_link' => $referralLink,
            'total_referrals' => $user->total_referrals,
            'bonus_parse_count' => $user->bonus_parse_count,
        ]);
    }

    /**
     * 处理推荐注册
     */
    public function processReferral(string $referralCode, User $newUser): void
    {
        $referrer = User::where('referral_code', $referralCode)->first();
        
        if ($referrer && $referrer->id !== $newUser->id) {
            // 创建推荐记录
            $referral = Referral::create([
                'referrer_id' => $referrer->id,
                'referred_user_id' => $newUser->id,
                'referral_code' => $referralCode,
                'bonus_awarded' => true,
            ]);

            // 给推荐人增加20次解析机会
            $referrer->addBonusParseCount(20);
        }
    }

    /**
     * 获取用户推荐统计
     */
    public function getReferralStats(): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $referrals = $user->referrals()
            ->with('referredUser:id,name,email,created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'total_referrals' => $user->total_referrals,
            'bonus_parse_count' => $user->bonus_parse_count,
            'referrals' => $referrals,
            'referral_code' => $user->getReferralCode(),
        ]);
    }
}